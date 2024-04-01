<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(private AddressService $addressService)
    {
        
    }

    public function index()
    {
        $addresses = $this->addressService->getUserAddresses();
        return view('admin.addresses.index', compact('addresses'));
    }

    // public function create()
    // {
    //     return view('admin.addresses.create');
    // }


    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();
        try 
        {
            $address = $this->addressService->store($validated);

            return back()->with('success', 'تم اضافة العنوان بنجاح');
        } catch (\Exception $e) 
        {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $res = $this->addressService->remove($id);
        if ($res) 
        {
            return back()->with('success', 'تم حذف العنوان بنجاح');
        }
        return back()->with('error', 'لم يتم العثور علي العنوان المطلوب');
    }
}
