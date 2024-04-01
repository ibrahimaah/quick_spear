<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressService 
{
    public function getUserAddresses()
    {
        $user = auth()->user();
        $addresses = Address::where('user_id', $user->id)->latest()->get();
        return $addresses;
    }

    public function preparing_data($validated)
    {
        $data = [
            'name' => $validated['name'],
            'user_id'   => Auth::id(),
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'region' => $validated['region'],
            'desc' => $validated['desc']
        ];
        return $data;
    }

    public function store($validated)
    {
        $data = $this->preparing_data($validated);
        $address = Address::create($data);
        return $address;
    }

    public function remove($id)
    {
        $address = Address::where(['id'=>$id,'user_id' => Auth::id()])->first();
        if($address)
        {
            $address->delete();
            return true;
        }
        return false;
    }
}