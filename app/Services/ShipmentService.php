<?php

namespace App\Services;
use App\Models\Address;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentService {
    public function store(Request $request):Shipment
    {
        foreach($request->shipments as $shipment):
                
            $data = [
                'user_id' => auth()->user()->id,
                'address_id' => Address::findOrFail($shipment['shipper'])->id,
                'consignee_name' => $shipment['consignee_name'],
                'consignee_phone' => $shipment['consignee_phone'],
                'consignee_phone_2' => $shipment['consignee_phone_2'],
                'consignee_country_code' => 'JO',
                'consignee_city' => $shipment['consignee_city'],
                'consignee_region' => $shipment['consignee_region'],
                'consignee_zip_code' => '',
                'shipping_date_time'    => now(),
                'due_date'  => now()->addHours(72),
                'order_price' => $shipment['order_price'],
                'customer_notes' => $shipment['customer_notes'],
                // 'delegate_notes' => $shipment['delegate_notes'],
            ];
            
            $shipment = Shipment::create($data);

        endforeach;

        return $shipment;
    }
}