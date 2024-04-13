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

    public function getAdminAddresses()
    {
        $admin = Auth::guard('admin')->user();
        $addresses = Address::where('admin_id', $admin->id)->latest()->get();
        return $addresses;
    }
    

    public function preparing_data($validated, $is_admin = false)
    {
        $data = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'region' => $validated['region'],
            'desc' => $validated['desc']
        ];
        // If the user is an admin, add admin_id to the data
        if ($is_admin) {
            $data['admin_id'] = Auth::guard('admin')->user()->id;
        } else {
            // Otherwise, add user_id
            $data['user_id'] = Auth::id();
        }
        return $data;
    }

    public function store($validated, $is_admin = false)
    {
        $data = $this->preparing_data($validated, $is_admin);
        $address = Address::create($data);
        return $address;
    }

    public function remove($id)
    {
        $address = Address::where(['id' => $id, 'user_id' => Auth::id()])->first();
        if ($address) {
            $address->delete();
            return true;
        }
        return false;
    }
}
