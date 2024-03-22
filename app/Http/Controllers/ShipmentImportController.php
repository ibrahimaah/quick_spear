<?php

namespace App\Http\Controllers;

use App\Imports\ShipmentImport;
use App\Models\Address;
use App\Models\City;
use App\Models\EditOrder;
use App\Models\Shipment;
use App\Models\ShipmentRate;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Octw\Aramex\Aramex;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ShipmentImportController extends Controller
{
    public function __construct()
    {
        if (auth('team')->check()) {
            $this->middleware(['auth:team']);
        } else {
            $this->middleware(['auth']);
        }
    }
    public function create()
    {
        return view('pages.user.express.import');
    }

    public function import_store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'importFile' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $rows = Excel::toCollection(new ShipmentImport(), $request->file('importFile'));

        // dd($rows[0]);
        foreach ($rows[0] as $row) {
            $city = City::where('name', 'LIKE', '%' . $row['city'] . '%')->first();
            $city2 = City::where('name', 'LIKE', '%' . $row['shipper_city'] . '%')->first();
            $address2 = Address::where('name', $row['shipper_name'])->where('user_id', auth()->user()->id)->first();
            if (!$address2 and $row['shipper_name'] !==null) {
                // dd($row);
                $address2 = Address::create(['phone' =>  $row['shipper_phone'] ?? $row['phone_number'],
                    'user_id' => auth()->user()->id,
                    'name' => $row['shipper_name'],
                    'city' => $city2->id,
                    'region' => $row['shipper_region'] ?? $row['shipper_city'],
                    'desc' => $row['shipper_address_description'],
                    'type' => 1,
                ]);
            }

            $row['address2'] = $address2;
            $row['city1'] = $city;
            $row['city2'] = $city2;
        }
        $rows = $rows[0];

        return view('pages.user.express.import', compact('rows'));
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