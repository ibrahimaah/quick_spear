<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;

class ShipmentService
{
    public function store(Request $request): Shipment
    {
        foreach ($request->shipments as $shipment) :
            $user_id = Address::findOrFail($shipment['shipper'])->user_id;
            $data = [
                'user_id' => $user_id,
                // 'address_id' => Address::findOrFail($shipment['shipper'])->id,
                'address_id' => $shipment['shipper'],
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
                'delegate_notes' => $shipment['delegate_notes'] ?? null,
            ];

            $shipment = Shipment::create($data);

        endforeach;

        return $shipment;
    }

    //assign delegate to shipments
    public function assign_delegate($delegate_id, $shipments_ids)
    {
        try 
        {
            $affectedRows = Shipment::whereIn('id', $shipments_ids)->update(['delegate_id' => $delegate_id]);
            if ($affectedRows > 0) 
            {
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error assign delegate');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }
}
