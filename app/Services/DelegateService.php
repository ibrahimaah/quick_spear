<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Delegate;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;

class DelegateService
{
    public function store($data,$cities)
    {
        try 
        {
            $delegate = Delegate::Create($data);

            if ($delegate) 
            {
                $delegate->cities()->attach($cities);
                return ['code' => 1, 'data' => $delegate];
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
    public function update($delegate_id,$data,$cities)
    {
        try 
        {
            $delegate = Delegate::findOrFail($delegate_id);

            $affectedRows =  $delegate->update($data);

            if ($affectedRows > 0) 
            {
                $delegate->cities()->sync($cities);
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

  

}
