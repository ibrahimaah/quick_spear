<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\City;
use App\Models\Shipment;
use App\Models\ShipmentRate;
use App\Models\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Octw\Aramex\Aramex;

class AdminShipmentImport implements ToCollection, WithValidation, WithHeadingRow
{
    use Importable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        $user = User::where('id', $this->user)->first();
        foreach ($rows as $row) {
            $address = Address::firstOrCreate(['name' => $row['shipper_name'], 'user_id' => $user->id], [
                'phone' => $row['shipper_phone'],
                'city' => $row['shipper_city'],
                'region' => $row['shipper_region'],
                'desc' => $row['shipper_address_description'],
            ]);
            $city = City::where('name', 'LIKE', '%' . $row['city'] . '%')->first();
            $city2 = City::where('name', 'LIKE', '%' . $row['shipper_city'] . '%')->first();
            $shipmentDetails = [
                'shipper' => [
                    'name' => $row['shipper_name'],
                    'email' => $user->email,
                    'phone' => $row['shipper_phone'],
                    'cell_phone' => $row['shipper_phone'],
                    'country_code' => 'JO',
                    'city' => $row['shipper_city'],
                    'zip_code' => '',
                    'line1' => $row['shipper_region'],
                    'line2' => $row['shipper_address_description'],
                ],
                'consignee' => [
                    'name' => $row['consignee_name'],
                    'email' => $user->email,
                    'phone' => $row['phone_number'],
                    'cell_phone' => $row['secondary_phone_number'],
                    'country_code' => 'JO',
                    'city' => $row['city'],
                    'zip_code' => '',
                    'line1' => $row['area'],
                    'line2' => $row['detailed_address'],
                ],
                // 'shipping_date_time' => now()->addHours(604800)->timestamp,
                'reference' => $user->ACCOUNT_NUMBER(),
                'shipper_reference' => $user->ACCOUNT_NUMBER(),
                'shipping_date_time' => time() + 50000,
                'due_date' => time() + 60000,
                'comments' => $row['notes'] ?? 'No Comment',
                'pickup_location' => 'at reception',
                'pickup_guid' => null,
                'services' => 'CODS',
                'cash_on_delivery_amount' => $row['cod'],
                'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                'payment_type' => 'P',
                'customs_value_amount' => 0,
                'weight' => $row['weight'],
                'number_of_pieces' => $row['pieces'],
                'description' => $row['shipment_content'],
            ];
            $callResponse = Aramex::createShipment($shipmentDetails);
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
                    'user_id' => $user->id,
                    'address_id' => $address->id,
                    'consignee_name' => $shipmentDetails['consignee']['name'],
                    'consignee_email' => $shipmentDetails['consignee']['email'],
                    'consignee_phone' => $shipmentDetails['consignee']['phone'],
                    'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
                    'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
                    'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
                    'consignee_line1' => $shipmentDetails['consignee']['line1'],
                    'consignee_line2' => $shipmentDetails['consignee']['line2'],
                    'consignee_line3' => $shipmentDetails['consignee']['line2'],
                    'consignee_city' => $city2->id,

                    // Shipment Data
                    'reference' => $user->ACCOUNT_NUMBER(),
                    'shipping_date_time'    => $shipmentDetails['shipping_date_time'],
                    'due_date'  => $shipmentDetails['due_date'],
                    'comments'  => $shipmentDetails['comments'],
                    'pickup_location'   => $shipmentDetails['pickup_location'],
                    'pickup_guid'   => $shipmentDetails['pickup_guid'],
                    'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'],
                    'product_group' => $shipmentDetails['product_group'],
                    'product_type'  => $shipmentDetails['product_type'],
                    'payment_type'  => $shipmentDetails['payment_type'],
                    'customs_value_amount'  => 0,
                    'collect_amount' => $this->sumExpress($city2->id, $city->id, $row['weight']),
                    'weight'    => $shipmentDetails['weight'],
                    'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
                    'description'   => $shipmentDetails['description'],
                    'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
                    'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
                    'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
                ];
                $ship = Shipment::create($data);
            }
        }
    }

    public function rules(): array
    {
        return [
             'shipper_name'             => 'required',
             'shipper_phone'            => 'required',
             'shipper_city'             => 'required',
             'shipper_region'             => 'required',
             'shipper_address_description'             => 'required',
             'consignee_name'           => 'required',
             'phone_number'             => 'required',
             'secondary_phone_number'   => 'required',
             'city'                     => 'required',
             'area'                     => 'required',
             'detailed_address'         => 'required',
             'notes'                    => 'required',
             'shipment_content'         => 'required',
             'pieces'                   => 'required',
             'cod'                      => 'required',
             'weight'                   => 'required',
        ];
    }

    public function sumExpress($city_from, $city_to, $wighte)
    {
        $value = 0;
        $user_id = $user->id;
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
}
