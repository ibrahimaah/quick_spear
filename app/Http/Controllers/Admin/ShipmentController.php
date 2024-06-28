<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExpressDataTable;
use App\DataTables\ShipmentDataTable;
use App\Exports\AdminShipmentsExport;
use App\Http\Controllers\Controller;
use App\Imports\TransactionsImport;
use App\Models\Address;
use App\Models\City;
use App\Models\Delegate;
use App\Models\EditOrder;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\Shop;
use App\Services\ShipmentService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Octw\Aramex\Aramex;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ShipmentController extends Controller
{

    public function __construct(private ShipmentService $shipmentService)
    {
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     // $shipments = Shipment::latest()->paginate(10);
    //     $shipments = Shipment::latest()->get();
    //     return view('admin.shipments.index', compact('shipments'));
    // }


    // public function get_shipments_by_status($status){
    //     $dataTable = new ShipmentDataTable($status);
    //     return $dataTable->render('admin.shipments.index');
    // }

    public function index(ExpressDataTable $dataTable)
    {
        // $dataTable = new ShipmentDataTable('3');
        $dataTable = new ExpressDataTable(true); 
        $delegates = Delegate::all();
        $shipment_statuses = ShipmentStatus::all();
        return $dataTable->render('admin.shipments.index',['delegates'=>$delegates,'shipment_statuses'=>$shipment_statuses]);
    }

    // public function export(Request $request)
    // {
    //     ini_set('memory_limit', '2048M');
    //     ini_set('max_execution_time', 500); 
        
    //     $fileName = 'shipments_' . $request->from . '_' . $request->to . '.' . $request->fileType;
    //     return Excel::download(new AdminShipmentsExport($request), $fileName);
    // }

    public function create(Request $request)
    {
        $shops = Shop::all();
        $delegates = Delegate::all();
        // return $dataTable->render('admin.shipments.create',['ships'=>$ships,'addresses'=>$addresses,'delegates'=>$delegates]); 
        return view('admin.shipments.create', ['shops'=>$shops,
                                               'delegates'=>$delegates]); 
    }

    public function store(Request $request)
    {
        try 
        {
            $shipment = $this->shipmentService->store($request,true);

            if($shipment)
            {
                return redirect()->route('admin.shipments.create')->with('success', 'تم اضافة الشحنة بنجاح');
            }
            else 
            {
                return redirect()->route('admin.shipments.create')->with('faild', 'حدث خطأ في إضافة الشحنة');
            }
            
        } 
        catch (\Exception $ex) 
        {
            return $ex->getMessage();
        }
    }

    public function show(Shipment $shipment)
    {
       
        if ($shipment) {
          
            return view('admin.shipments.show', compact('shipment'));
        }
    }
    /*
    public function show(Shipment $shipment)
    {
        $generator = new BarcodeGeneratorPNG();
        $editOrders = EditOrder::where(['shipment_id' => $shipment->id])->get();
        if ($shipment) {
            // dd($shipment);
            $barcode = base64_encode($generator->getBarcode($shipment->shipmentID, $generator::TYPE_CODE_128));
            $data = Aramex::trackShipments([$shipment->shipmentID]);
            // dd($data);
            if (!$data->HasErrors && !isset($data->NonExistingWaybills->string)) {
                $det = $data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
                if (gettype($det) == "array") {
                    if ($det[0]->UpdateCode == "SH014") {
                        $shipment->update(['status' => 0]);
                    }
                    if (array_search($det[0]->UpdateCode, $this->status1) !== false) {
                        $shipment->update(['status' => 1]);
                    }
                    if (array_search($det[0]->UpdateCode, $this->status2) !== false) {
                        $shipment->update(['status' => 2]);
                    }
                    if ($det[0]->UpdateCode == "SH069") {
                        $shipment->update(['status' => 3]);
                    }
                } else {
                    if ($det->UpdateCode == "SH014") {
                        $shipment->update(['status' => 0]);
                    }
                }


                return view('admin.shipments.show', compact('shipment', 'data', 'barcode', 'editOrders'));
                // return view('admin.shipments.show', compact('shipment'));
            }
            return view('admin.shipments.show', compact('shipment', 'data', 'barcode', 'editOrders'));
        }
    }
    */
    public function edit(Shipment $shipment)
    {
        $delegates = Delegate::all();
        $shops = Shop::all();
        $shipment_statuses = ShipmentStatus::all(); 
        return view('admin.shipments.edit', compact('shipment','delegates','shops','shipment_statuses'));
    }

    public function update(Request $request, Shipment $shipment)
    {
       
        // dd($request->all());
        $res_update_shipment = $this->shipmentService->update($request,$shipment,true);

        if ($res_update_shipment['code'] == 1) {
            return redirect()->back()->with("success_update", "تم تعديل البيانات بنجاح");
        }
        else {
            dd($res_update_shipment['msg']);
            return redirect()->back()->with("faild_update",$res_update_shipment['msg'] );
        }
        
    }

    public function destroy(Shipment $shipment)
    {
        $res_remove = $this->shipmentService->remove($shipment->id);
        
        if ($res_remove['code'] == 1) 
        {
            return redirect()->back()->with('success_delete', 'تم حذف البيانات بنجاح');
        }
        else
        {
            return redirect()->back()->with('error_delete', $res_remove['msg']);
        }
    }



    // Imports
    public function import_create()
    {
        return view('admin.shipments.create');
    }

    public function import_store(Request $request)
    {
        try {
            Excel::import(new TransactionsImport($request->user_id), $request->file('importFile'));
            return back()->with('success', 'تم تحميل البيانات');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function assign_delegate(Request $request)
    {
        $selectedShipments = $request->input('selected_shipments');
        $selectedShipmentsArray = explode(',', $selectedShipments);

        $res_assign_delegate = $this->shipmentService->assign_delegate($request->delegate,$selectedShipmentsArray);
        if ($res_assign_delegate['code']==1) 
        {
            return redirect()->back()->with('success', 'تمت العملية بنجاح');
        }
        else
        {
            return redirect()->back()->with('error', $res_assign_delegate['msg']);
        }
    }

    public function cancel_assign_delegate($shipment_id)
    {
        $res_cancel = $this->shipmentService->cancel_assign_delegate($shipment_id);

        if($res_cancel['code']==1)
        {
            return redirect()->back()->with('success', 'تمت العملية بنجاح');
        }
        else
        {
            return redirect()->back()->with('error', $res_cancel['msg']);
        }
    }

    public function update_status(Shipment $shipment , $shipment_status_id)
    {
        $res_update_status = $this->shipmentService->update_status($shipment,$shipment_status_id);
        if ($res_update_status['code'] == 1) 
        {
            return response()->json(['code' => 1 , 'data' => true]);
        }
        else 
        {
            return response()->json(['code' => 0 , 'msg' => $res_update_status['msg']]);
        }
    }
}
