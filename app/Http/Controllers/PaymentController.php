<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Exports\TransactionsExport;
use App\Models\Address;
use App\Models\City;
use App\Models\Company;
use App\Models\EditOrder;
use App\Models\PaymentMethod;
use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

file:///home/shehabalqudiry/Downloads/Form-Fields-Repeater/index.html

use Aramex;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PaymentController extends Controller
{
    public function __construct()
    {
        if (auth('team')->check()) {
            $this->middleware(['auth:team']);
        } else {
            $this->middleware(['auth']);
        }
    }

   

    public function export(Request $request)
    {
        $fileName = 'transactions_' . $request->from . '_' . $request->to . '.' . $request->fileType;
        return Excel::download(new TransactionsExport($request), $fileName);
        // return back()->with('success', __('The action ran successfully!'));
    }
    public function index(Request $request)
    {
        $shipments = null;
        $transactions = Transaction::where('user_id', auth()->user()->id)->withSum('imports', 'CODValue')->get();
        if ($request->from) {
            $transactions = Transaction::where('user_id', auth()->user()->id)->withSum('imports', 'CODValue')->whereBetween('created_at', [$request->from, $request->to])->latest()->get();
        }
        // if($request->status) {
            if($request->status == 1) {
                $transactions = Transaction::where('user_id', auth()->user()->id)->where('status', '=' ,1)->withSum('imports', 'CODValue')->latest()->get();
    
            }else if($request->status == 2){
                $transactions = Transaction::where('user_id', auth()->user()->id)->where('status', '!=', 1)->withSum('imports', 'CODValue')->latest()->get();
    
            }else if($request->status == 0){
                $transactions = Transaction::where('user_id', auth()->user()->id)->withSum('imports', 'CODValue')->get();
            }
        // }
        foreach ($transactions as $transaction) {
            $awb = [];
            foreach ($transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', auth()->user()->id)->get();

            $transaction->value = $shipments->sum('cash_on_delivery_amount') - $shipments->sum('collect_amount');
          
        }


            $tr_rev = Transaction::where('user_id', auth()->user()->id)->where('status', '=' , 0)->withSum('imports', 'CODValue')->get();
            $awbb = [];
            foreach ($tr_rev as $transaction) {
                
                foreach ($transaction->imports as $im) {
                    $awbb[] = $im->AWB;
                }
            }
            $shipments_rev = Shipment::whereIn('shipmentID', $awbb)->where('user_id', auth()->user()->id)->sum('collect_amount');



        return view('pages.user.payments.index', compact('transactions', 'shipments','shipments_rev'));
    }

    public function show($transaction)
    {
        $mainId = $transaction;
        $transaction = Transaction::where(['id' => $transaction, 'user_id' => auth()->user()->id])->first();
        if (!$transaction) {
            return back()->with('error', 'Not Found');
        }
        $awb = [];
        foreach ($transaction->imports as $im) {
            $awb[] = $im->AWB;
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', auth()->user()->id)->latest()->get();
        // $shipments = $awb;
        return view('pages.user.payments.show', compact(['shipments','mainId']));
    }

    public function exportPayment(Request $request)
    {
        // return $request;

        $fileName = 'paymentExported.'.$request->fileType;
        if ($request->fileType == 'pdf'){
            $transaction = Transaction::where(['id' => $request->id , 'user_id' => auth()->user()->id])->first();
        if (!$transaction) {
            return back()->with('error', 'Not Found');
        }
        $awb = [];
        foreach ($transaction->imports as $im) {
            $awb[] = $im->AWB; 
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', auth()->user()->id)->latest()->get(); 

            $pdf = PDF::loadView('pages.user.express.export',['shipments' => $shipments->toArray(), 'pdf' => true]);
            return $pdf->download($fileName);
        }
        return Excel::download(new PaymentExport($request->id, auth()->user()->id), $fileName);
    }

 
    public function PaymentRequestSend(Request $request)
    {
        // return $request;
        $user = auth()->user();
        $rules = [
            'payment_method_id' => 'required',
            'transaction_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user->paymentRequests()->create([
                'payment_method_id' => $request->payment_method_id,
                'transaction_id' => $request->transaction_id,
            ]);

            return back()->with('success', __('Payment Request') . ' : ' . __('The action ran successfully!'));
        } catch (\Exception $e) {
            // return $e->getMessage();
            return back()->with('error', $e->getMessage());
        }
    }

    public function checked(Request $request)
    {
        // return $request;

        $user = auth()->user();
        $rules = [
            'payment_method_id' => 'required',
            'checked' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules,['required' => 'لا يوجد وسيلة دفع متوفره']);
        if ($validator->fails()) {
            // return back()->withErrors($validator)->withInput();
            return back()->with('error','لا يوجد وسيلة دفع متوفره');
        }
        try {
            foreach ($request->checked as $check) {
                $user->paymentRequests()->create([
                    'payment_method_id' => $request->payment_method_id,
                    'transaction_id' => $check,
                ]);
            }
            // return back()->with('success', __('Payment Request') . ' : ' . __('The action ran successfully!'));
            return response()->json([
                'message' => __('Payment Request') . ' : ' . __('The action ran successfully!')
            ]);
        } catch (\Exception $e) {
            // return $e->getMessage();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return back()->with('success', __('Payment Request') . ' : ' . __('The action ran successfully!'));
    }
}
