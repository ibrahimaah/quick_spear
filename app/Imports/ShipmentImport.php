<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\City;
use App\Models\Shipment;
use App\Models\ShipmentRate;
use App\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Octw\Aramex\Aramex;

class ShipmentImport implements ToCollection, WithValidation, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $address2 = Address::firstOrCreate(['name' => $row['shipper_name'], 'user_id' => auth()->user()->id],[
                'phone' => $row['shipper_phone'],
                'city' => $row['shipper_city'],
                'region' => $row['shipper_region'],
                'desc' => $row['shipper_address_description'],
            ]);
            $city = City::where('name', 'LIKE', '%' . $row['city'] . '%')->first();
            $city2 = City::where('name', 'LIKE', '%' . $row['shipper_city'] . '%')->first();

            $row->address2 = $address2;
            $row->city1 = $city;
            $row->city2 = $city2;
        }
        return $rows;
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
        $user_id = auth()->user()->id;
        $shipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->first();

        $userShipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->where('user_id', $user_id)->first();
        if (!$shipRate || !$userShipRate) {
            return $value;
        }

        if($userShipRate){
            $shipRate = $userShipRate;
        }
        if(in_array($wighte, range(1,10))){
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
        }elseif (in_array($wighte, range(101, 105))) {
            $value = $shipRate->rate * 9.5;
        }
        return $value;
    }

}
