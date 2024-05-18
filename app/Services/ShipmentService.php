<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ShipmentService
{
    public function store(Request $request,$by_admin=false): Shipment
    { 
        foreach ($request->shipments as $shipment) : 
            $shop_id = $by_admin ? $shipment['shop'] : $request->shop;
            $data = [ 
                'shop_id' => $shop_id,
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
                'delegate_id' => $shipment['delegate'] ?? null,
                'delegate_notes' => $shipment['delegate_notes'] ?? null,
            ];

            
            $shipment = Shipment::create($data);

        endforeach;

        return $shipment;
    }

    public function update(Request $request,Shipment $shipment,$by_admin=false)
    {
        try 
        { 
            
            $data = [ 
                // 'address_id' => $request->address,
                'shop_id' => $request->shop,
                'consignee_name' => $request->consignee_name,
                'consignee_phone' => $request->consignee_phone,
                'consignee_phone_2' => $request->consignee_phone_2,
                'consignee_city' => $request->consignee_city,
                'consignee_region' => $request->consignee_region,
                'order_price' => $request->order_price,
                'customer_notes' => $request->customer_notes,
                'delegate_id' => $request->delegate ?? null,
                'delegate_notes' => $request->delegate_notes ?? null,
                'status' => $request->status,
                'consignee_country_code' => 'JO',
                'consignee_zip_code' => '',
                'shipping_date_time'    => now(),
                'due_date'  => now()->addHours(72),
            ];

            
            if($shipment->status == ShipmentStatus::UNDER_REVIEW && $request->status == ShipmentStatus::UNDER_DELIVERY)
            {
                $data['accepted_by_admin_at'] = Carbon::now()->toDateTimeString();
            }

            if ($by_admin) 
            {
                $data['value_on_delivery'] = $request->value_on_delivery;
            }

            if ($shipment->update($data)) 
            {
                return ['code' => 1, 'data' => true ];
            }
            else 
            {
                throw new Exception('Error in updating shipment');
            }
            ///////////////////////////////////////////////////////////
        }
        catch(Exception $ex)
        {
            return ['code'=>0,'msg'=>$ex->getMessage()];
        }
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

    public function remove($id)
    {
        try 
        {
            $shipment = Shipment::findOrFail($id);
            
            if ($shipment->delete()) 
            {
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error in deleting shipment');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }

    public function cancel_assign_delegate($id)
    {
        try 
        {
            $shipment = Shipment::findOrFail($id);
            $shipment->delegate_id = null;
            if ($shipment->save()) 
            {
                return ['code' => 1, 'data' => true];
            }
            else 
            {
                throw new Exception('Error in cancel assign');   
            }
        }
        catch(Exception $ex)
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }


    public function get_selected_shipments($ids)
    {
        try 
        {
            $shipments = Shipment::whereIn('id', $ids)->get();
            
            if ($shipments->isNotEmpty()) 
            {
                return ['code' => 1, 'data' => $shipments];
            }
            else 
            {
                throw new Exception('Error in getting selected shipments');   
            }
        }
        catch(Exception $ex)
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }


  
}
