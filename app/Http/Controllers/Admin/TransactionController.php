<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminPaymentExport;
use App\Exports\AdminTransactionsExport;
use App\Exports\PaymentExport;
use App\Models\Company;
use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class TransactionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['super_admin']);
    // }
    public function index()
    {
        $transactions = Transaction::get();
        foreach ($transactions as $transaction) {
            $awb = [];
            foreach ($transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->get();
            $transaction->value = $shipments->sum('cash_on_delivery_amount') - $shipments->sum('collect_amount');
        }
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('admin.transactions.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'name_ku' => 'required',
            'company' => 'required',
            'photo'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        Transaction::create([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ],
            'company_id' => $request->company,
            'photo'      => $request->hasFile('photo') ? uploadImage('transactions', $request->file('photo')) : 'images/default.png',
        ]);
        return redirect()->route('admin.transactions.index')->with("success", "تم اضافة القسم بنجاح");
    }

    public function show(Transaction $Transaction)
    {
        $mainId = $Transaction->id;
        $awb = [];
        foreach ($Transaction->imports as $im) {
            $awb[] = $im->AWB;
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->get();
        return view('admin.transactions.show', compact(['shipments', 'mainId']));
    }

    public function edit(Transaction $Transaction)
    {
        $companies = Company::get();
        return view('admin.transactions.edit', compact(['Transaction', 'companies']));
    }

    public function update(Request $request, Transaction $Transaction)
    {
        $rules = [
            'status' => 'required',
            'image'   => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        $Transaction->update([
            'status'     => $request->status,
            'image'      => $request->hasFile('photo') ? uploadImage('transactions', $request->file('image')) : $Transaction->image,
        ]);
        if ($request->status == 1) {
            $awb = [];
            foreach ($Transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->get();
            foreach ($shipments as $shipment) {
                $shipment->update(['status' => 5]);
            }
        }
        return redirect()->route('admin.transactions.index')->with("success", "تم تعديل البيانات بنجاح");
    }


    public function indexRequest()
    {
        $requests = PaymentRequest::latest()->get();
        return view('admin.transactions.requests', compact('requests'));
    }

    function uploadImage($folder, $image)
        {
            //$image->store( $folder);
            $ex = $image->getClientOriginalExtension();
            $filename = time().'.'.$ex;
            $path2 = public_path("images/".$folder);
            $image->move($path2,$filename);
            $path = 'images/' . $folder . '/' . $filename;
            return $path;
        }

    public function updateRequest(Request $request, $paymentRequest)
    {
        $paymentRequest = PaymentRequest::findOrFail($paymentRequest);
        $rules = [
            'status' => 'required',
            'image'   => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $paymentRequest->update([
            'status'     => $request->status,
        ]);
        $Transaction = Transaction::find($paymentRequest->transaction_id);
        $Transaction->update([
            'status' => $request->status,
            'image'       => $request->hasFile('photo') ? uploadImage('transactions', $request->file('photo')) : $Transaction->image,
        ]);
        if ($request->status == 1) {
            $awb = [];
            foreach ($paymentRequest->transaction->imports as $im) {
                $awb[] = $im->AWB;
            }
            // return $awb;
            $shipments = Shipment::whereIn('shipmentID', array_unique($awb));
            // return $shipments->get();
            foreach ($shipments->get() as $shipment) {
                // $shipment->update(['status' => 5]);
                $shipment->status = 5;
                $shipment->update();
            }
            
        }
        return redirect()->route('admin.requests.index')->with("success", "تم تعديل البيانات بنجاح");
    }

    public function destroy(Transaction $Transaction)
    {
        if ($Transaction->image !== 'images/default.png') {
            Storage::delete($Transaction->image);
        }
        $Transaction->delete();
        return redirect()->route('admin.transactions.index')->with("success", "تم حذف البيانات بنجاح");
    }

    public function export(Request $request)
    {
        $fileName = 'Transactions.'.$request->fileType;
        $transactions = Transaction::get();
        foreach ($transactions as $transaction) {
            $awb = [];
            foreach ($transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->get();
            $transaction->value = $shipments->sum('cash_on_delivery_amount') - $shipments->sum('collect_amount');
        }
        if ($request->fileType == 'pdf'){
            $pdf = PDF::loadView('pages.user.express.export',['shipments' => $shipments->toArray(), 'pdf' => true]);
            return $pdf->download($fileName);
        }
        return Excel::download(new AdminTransactionsExport($request), $fileName);
    }

    public function exportPayment(Request $request)
    {
        // return $request;
        $fileName = 'paymentExported.'.$request->fileType;
        if ($request->fileType == 'pdf'){
            $transaction = Transaction::where('id', $request->id)->first();
        if (!$transaction) {
            return back()->with('error', 'Not Found');
        }
        $awb = [];
        foreach ($transaction->imports as $im) {
            $awb[] = $im->AWB; 
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->latest()->get(); 

            $pdf = PDF::loadView('pages.user.express.export',['shipments' => $shipments->toArray(), 'pdf' => true]);
            return $pdf->download($fileName);
        }
        return Excel::download(new AdminPaymentExport($request->id), $fileName);
    }


}
