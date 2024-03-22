<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ShipmentDataTable;
use App\Exports\AdminShipmentsExport;
use App\Http\Controllers\Controller;
use App\Imports\TransactionsImport;
use App\Models\Address;
use App\Models\City;
use App\Models\EditOrder;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Octw\Aramex\Aramex;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ShipmentController extends Controller
{
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

    public function index(ShipmentDataTable $dataTable)
    {
        return $dataTable->render('admin.shipments.index');
    }

    public function export(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 500); 
        
        $fileName = 'shipments_' . $request->from . '_' . $request->to . '.' . $request->fileType;
        return Excel::download(new AdminShipmentsExport($request), $fileName);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $shipper = Address::findOrFail($request->shipper);
        $data = [
            'address_id' => $shipper->id,
            'consignee_name' => $request->consignee_name,
            'consignee_phone' => $request->consignee_phone,
            'consignee_phone_2' => $request->consignee_phone_2,  
            'consignee_city' => $request->consignee_city,
            'consignee_region' => $request->consignee_region,
            'status' => $request->status ?? 0,

            // Shipment Data
            'notes' => $request->notes ?? 'No Note',  
            'order_price' => $request->order_price,
        ];
        $shipment->update($data);

        return back()->with("success", "تم تعديل البيانات بنجاح");
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return back()->with('success', 'تم حذف البيانات بنجاح');
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
}
