<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Pickup;
use App\Models\Address;
use Octw\Aramex\Aramex;
use App\Models\Shipment;
use App\Models\EditOrder;
use App\Models\ShipmentRate;
use Illuminate\Http\Request;
use App\Exports\ShipmentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function testUpload(Request $request)
    {

    }

    public function sumExpress($city_from, $city_to, $wighte)
    {
        $value = 0;
        $user_id = 2;
        $shipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->first();

        $userShipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->where('user_id', $user_id)->first();
        if (!$shipRate || !$userShipRate) {
            return $value;
        }

        if ($userShipRate) {
            $shipRate = $userShipRate;
        }
        if (in_array($wighte, range(1, 10))) {
            $value = $shipRate->rate;
        } elseif (in_array($wighte, range(11, 20))) {
            $value = $shipRate->rate * 1.5;
        } elseif (in_array($wighte, range(21, 30))) {
            $value = $shipRate->rate * 2;
        } elseif (in_array($wighte, range(31, 40))) {
            $value = $shipRate->rate * 2.5;
        } elseif (in_array($wighte, range(41, 50))) {
            $value = $shipRate->rate * 3.5;
        } elseif (in_array($wighte, range(51, 60))) {
            $value = $shipRate->rate * 4.5;
        } elseif (in_array($wighte, range(61, 70))) {
            $value = $shipRate->rate * 5.5;
        } elseif (in_array($wighte, range(71, 80))) {
            $value = $shipRate->rate * 6.5;
        } elseif (in_array($wighte, range(81, 90))) {
            $value = $shipRate->rate * 7.5;
        } elseif (in_array($wighte, range(91, 100))) {
            $value = $shipRate->rate * 8.5;
        } elseif (in_array($wighte, range(101, 105))) {
            $value = $shipRate->rate * 9.5;
        }
        return $value;
    }


    public function AramixCreateShipment($shipmentDetails,$shipper,$ship)
    {
         // dd($shipmentDetails);
         $callResponse = Aramex::createShipment($shipmentDetails);
         // if (false) {
         if (!empty($callResponse->error)) {
             foreach ($callResponse->errors as $errorObject) {
                 return $errorObject->Code . ' => ' . $errorObject->Message;
             }
         } else {
             $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
             $putFile = file_put_contents($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
             // $putFile = Storage::put($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
             $data = [
                 'user_id' => $shipper->id,
                 'address_id' => $shipper->id,
                 'consignee_name' => $shipmentDetails['consignee']['name'],
                 'consignee_email' => $shipmentDetails['consignee']['email'] ?? 'test@admin.com',
                 'consignee_phone' => $shipmentDetails['consignee']['phone'],
                 'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
                 'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
                 'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
                 'consignee_line1' => $shipmentDetails['consignee']['line1'],
                 'consignee_line2' => $shipmentDetails['consignee']['line2'],
                 'consignee_line3' => $shipmentDetails['consignee']['line2'],
                 'consignee_city' => $ship['consignee_city'],

                 // Shipment Data
                 'reference' => $ship['reference'] ?? '4688611',
                 'shipping_date_time'    => now()->addHours(2),
                 'due_date'  => now()->addHours(72),
                 'comments'  => $shipmentDetails['comments'],
                 'pickup_location'   => $shipmentDetails['pickup_location'],
                 'pickup_guid'   => $shipmentDetails['pickup_guid'],
                 'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'] ?? 5,
                 'product_group' => $shipmentDetails['product_group'],
                 'product_type'  => $shipmentDetails['product_type'],
                 'payment_type'  => $shipmentDetails['payment_type'],
                 'customs_value_amount'  => 0,
                 'collect_amount' => $this->sumExpress($shipper->city, $shipper->city, $ship['weight']),
                 'weight'    => $shipmentDetails['weight'],
                 'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
                 'description'   => $shipmentDetails['description'],
                 'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
                 'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
                 'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
             ];
             return $data;
         }
    }

    public function store(Request $request)
    {
        // return $request->shipments;
        if ($request->shipments) {
            foreach ($request->shipments as $ship) {
                // dd($ship);
                $shipper = Address::findOrFail($ship['shipper']);
                $city = City::where('id', $shipper->city)->orWhere('name', $shipper->city)->first();
                // dd($city);
                $destinationCity = City::where('id', $ship['consignee_city'])->first();
                $shipmentDetails = [
                    'shipper' => [
                        'name' => $shipper->name,
                        'email' => $shipper->email,
                        'phone' => $shipper->phone,
                        'cell_phone' => $shipper->phone,
                        'country_code' => 'JO',
                        'city' => $city->name,
                        'zip_code' => '',
                        'line1' => $shipper->desc,
                        'line2' => $shipper->desc,
                    ],
                    'consignee' => [
                        'name' => $ship['consignee_name'],
                        'email' => $shipper->email,
                        'phone' => $ship['consignee_phone'],
                        'cell_phone' => $ship['consignee_cell_phone'] ?? $ship['consignee_phone'],
                        'country_code' => 'JO',
                        'city' => $destinationCity->name,
                        'zip_code' => '',
                        'line1' => $ship['consignee_line1'] ?? $destinationCity->name,
                        'line2' => $ship['consignee_line2'] ?? $destinationCity->name,
                    ],
                    'shipping_date_time' => now()->addHours(2)->timestamp,
                    'reference' => $ship['reference'] ?? '4688611',
                    'shipper_reference' => $ship['reference'] ?? '4688611',
                    // 'shipping_date_time' => time() + 50000,
                    'due_date' => now()->addHours(72)->timestamp,
                    'comments' => $ship['comments'] ?? 'No Comment',
                    'pickup_location' => 'at reception',
                    'pickup_guid' => null,
                    'services' => 'CODS',
                    'cash_on_delivery_amount' => floatval(number_format($ship['cash_on_delivery_amount'] ?? 5, 2)),
                    'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                    'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                    'payment_type' => 'P',
                    'customs_value_amount' => 0,
                    'weight' => $ship['weight'] ?? 2,
                    'number_of_pieces' => $ship['number_of_pieces'] ?? 5,
                    'description' => $ship['description'] ?? 'des',
                ];
                $data = $this->AramixCreateShipment($shipmentDetails,$shipper,$ship);
                if (is_array($data)) {
                    // $ship = Shipment::create($data);
                }else{
                    return $data;
                }
                
            }
            // return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
            return redirect()->url('/ar/express/')->with('success', 'تم اضافة الشحنة بنجاح');
        } else {
            $validator = Validator::make($request->all(), [
                "consignee_name"  => "required|min:3",
                "consignee_phone"  => "required|min:8",
                "consignee_city"  => "required",
                "cash_on_delivery_amount"  => "required",
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            // dd(Aramex::fetchCities('JO'));
            try {
                //code...
                $shipper = Address::findOrFail($request->shipper);
                $city = City::where('id', $shipper->city)->first();
                $destinationCity = City::where('id', $request->consignee_city)->first();
                $shipmentDetails = [
                    'shipper' => [
                        'name' => $shipper->name ?? 'test',
                        'email' => $shipper->email,
                        'phone' => $shipper->phone,
                        'cell_phone' => $shipper->phone,
                        'country_code' => 'JO',
                        'city' => $city->name ?? 'Amman',
                        'zip_code' => '',
                        'line1' => $shipper->desc,
                        'line2' => $shipper->desc,
                    ],
                    'consignee' => [
                        'name' => $request->consignee_name,
                        'email' => $shipper->email,
                        'phone' => $request->consignee_phone,
                        'cell_phone' => $request->consignee_cell_phone ?? $request->consignee_phone,
                        'country_code' => 'JO',
                        'city' => $destinationCity->name,
                        'zip_code' => '',
                        'line1' => $request->consignee_line1,
                        'line2' => $request->consignee_line2,
                    ],
                    // 'shipping_date_time' => now()->addHours(604800)->timestamp,
                    'reference' => $request->reference,
                    'shipper_reference' => $request->reference,
                    'shipping_date_time' => time() + 50000,
                    'due_date' => time() + 60000,
                    'comments' => $request->comments ?? 'No Comment',
                    'pickup_location' => 'at reception',
                    'pickup_guid' => null,
                    'services' => 'CODS',
                    'cash_on_delivery_amount' => floatval(number_format($request->cash_on_delivery_amount, 2)),
                    'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                    'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                    'payment_type' => 'P',
                    'customs_value_amount' => 0,
                    'weight' => $request->weight,
                    'number_of_pieces' => $request->number_of_pieces,
                    'description' => $request->description,
                ];
                // dd($shipmentDetails);
                $callResponse = Aramex::createShipment($shipmentDetails);
                // if (false) {
                if (!empty($callResponse->error)) {
                    foreach ($callResponse->errors as $errorObject) {
                        return $errorObject->Code . ' => ' . $errorObject->Message;
                    }
                } else {
                    $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
                    $putFile = file_put_contents($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
                    // dd($putFile);
                    // $fileUpload = Storage::putFile('lables/' . $callResponse->Shipments->ProcessedShipment->ID . '/' , $putFile);
                    // dd($callResponse);
                    $data = [
                        'user_id' => $shipper->id,
                        'address_id' => $shipper->id,
                        'consignee_name' => $shipmentDetails['consignee']['name'],
                        'consignee_email' => $shipmentDetails['consignee']['email'],
                        'consignee_phone' => $shipmentDetails['consignee']['phone'],
                        'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
                        'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
                        'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
                        'consignee_line1' => $shipmentDetails['consignee']['line1'],
                        'consignee_line2' => $shipmentDetails['consignee']['line2'],
                        'consignee_line3' => $shipmentDetails['consignee']['line2'],
                        'consignee_city' => $request->consignee_city,

                        // Shipment Data
                        'reference' => $request->reference,
                        'shipping_date_time'    => now()->addHours(2),
                        'due_date'  => now()->addHours(72),
                        'comments'  => $shipmentDetails['comments'],
                        'pickup_location'   => $shipmentDetails['pickup_location'],
                        'pickup_guid'   => $shipmentDetails['pickup_guid'],
                        'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'],
                        'product_group' => $shipmentDetails['product_group'],
                        'product_type'  => $shipmentDetails['product_type'],
                        'payment_type'  => $shipmentDetails['payment_type'],
                        'customs_value_amount'  => 0,
                        'collect_amount' => $this->sumExpress($shipper->city, $shipper->city, $request->weight),
                        'weight'    => $shipmentDetails['weight'],
                        'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
                        'description'   => $shipmentDetails['description'],
                        'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
                        'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
                        'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
                    ];
                    $ship = Shipment::create($data);
                }

                return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
}