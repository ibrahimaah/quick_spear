<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use App\Services\RegionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{

    public function __construct(private RegionService $regionService){}

    public function index()
    {
        $regions = Region::all();
        
        return view('admin.regions.index', compact('regions'));
    }


    public function create()
    {
        $cities = City::all();
        return view('admin.regions.create',compact('cities'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'city'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $region_data = [
            'name' => $request->name,
            'city_id' => $request->city,
        ];

        $res_store_region = $this->regionService->store($region_data);

        if ($res_store_region['code'] == 1) 
        {
            return redirect()->route('admin.regions.index')->with("success", "تم اضافة البيانات بنجاح");
        }
        else 
        {
            dd($res_store_region['msg']);
        }
    }

    public function edit(Region $region)
    {
        $cities = City::all();
        return view('admin.regions.edit', compact('region','cities'));
    }

    public function update(Request $request, Region $region)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
         $region_data = [
            'name' => $request->name,
            'city_id' => $request->city,
        ];

        $res_update_region = $this->regionService->update($region_data,$region);

        if ($res_update_region['code'] == 1) 
        {
            return redirect()->route('admin.regions.index')->with("success", "تم تعديل البيانات بنجاح");
        }
        else 
        {
            dd($res_update_region['msg']);
        }
    }

    public function destroy(Region $region)
    {
       $res_destroy_region = $this->regionService->destroy($region);
       if ($res_destroy_region['code'] == 1) 
       {
            return redirect()->route('admin.regions.index')->with("success", "تم حذف البيانات بنجاح");
       }
       else 
       {
        dd($res_destroy_region['msg']);
       }
        
    }
}
