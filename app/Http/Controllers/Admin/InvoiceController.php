<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShipmentService;
use Illuminate\Http\Request;
use PDF;
use Exception;

class InvoiceController extends Controller
{
    public function __construct(private ShipmentService $shipmentService)
    {
        
    }
    public function invoice(Request $request)
    {
        $selectedShipmentsIds = $request->input('selected_shipments');
        $selectedShipmentsIdsArray = explode(',', $selectedShipmentsIds);
        $res_get_selected_shipments = $this->shipmentService->get_selected_shipments($selectedShipmentsIdsArray);
        
        if ($res_get_selected_shipments['code'] == 1) {
            $selected_shipments = $res_get_selected_shipments['data'];
            set_time_limit(300);
            $pdf = PDF::loadView('admin.invoices.index',['selected_shipments'=>$selected_shipments]);
            return $pdf->stream('invoice.pdf');

        }
        else{
            return back()->with('error',$res_get_selected_shipments['msg']);
        }
        
        /*
           set_time_limit(300);
            $pdf = PDF::loadView('admin.invoices.index');
            return $pdf->stream('invoice.pdf');
         */
        
    }
}
