<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ShipmentRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::latest()->get();
        return view('admin.cities.index', compact('cities'));
    }


    public function create()
    {
        return view('admin.cities.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'status'   => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        if (City::where('name', $request->name)->count() > 0) {
            return redirect()->back()->with("error", "تم اضافة هذه المدينه من قبل");
        }

        City::create([
            'name' => $request->name,
            'status'=> $request->status
        ]);
        return redirect()->route('admin.cities.index')->with("success", "تم اضافة البيانات بنجاح");
    }

    public function rates($id)
    {
        $city = City::findOrFail($id);
        $rates = ShipmentRate::where(['city_from' => $id])->orWhere(['city_to' => $id])->where('user_id', null)->get();
        return view('admin.cities.rates', compact('rates', 'city'));
    }


    public function add_rate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from'     => 'required|exists:cities,id',
            'to'       => 'required|exists:cities,id',
            'rate'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        if ($request->user_id) {
            $rat = ShipmentRate::where([
                'user_id'   => $request->user_id,
                'city_from' => $request->from,
                'city_to'   => $request->to,
            ])->first();

            if (!$rat) {
                ShipmentRate::create([
                    'user_id'   => $request->user_id,
                    'city_from' => $request->from,
                    'city_to'   => $request->to,
                    'rate'      => $request->rate,
                ]);
            } else {
                $rat->update([
                    'rate'      => $request->rate,
                ]);
            }
            return back()->with("success", "تمت العملية بنجاح");
        }
        ShipmentRate::create([
            'user_id'   => 0,
            'city_from' => $request->from,
            'city_to'   => $request->to,
            'rate'      => $request->rate,
        ]);
        return back()->with("success", "تم اضافة البيانات بنجاح");
    }

    public function update_rate(Request $request, $id)
    {
        $rate = ShipmentRate::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'rate'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $rate->update([
            'rate'      => $request->rate
        ]);
        return back()->with("success", "تم تعديل البيانات بنجاح");
    }


    public function edit(City $city)
    {
        return view('admin.cities.edit', compact(['city']));
    }

    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        $city->update([
            'name' => $request->name,
            'status'=> $request->status
        ]);
        return redirect()->route('admin.cities.index')->with("success", "تم اضافة البيانات بنجاح");
    }

    public function rate_destroy($rate)
    {
        $rate = ShipmentRate::findOrFail($rate);
        $rate->delete();
        return back()->with("success", "تم حذف البيانات بنجاح");
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')->with("success", "تم حذف البيانات بنجاح");
    }
}
