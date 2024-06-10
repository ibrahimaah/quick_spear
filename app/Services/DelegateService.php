<?php

namespace App\Services;

use App\Models\Address;
use App\Models\City;
use App\Models\Delegate;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;

class DelegateService
{
    public function store($data)
    {
        try 
        {
            $delegate_table_data = [
                'name' => $data['name'],
                'phone' => $data['phone'],
            ];

            $delegate = Delegate::Create($delegate_table_data);

            if ($delegate) 
            {
                $delegate_pivote_data = $data['delegates'];
                // Attach delegate to each city with price
                foreach ($delegate_pivote_data as $delegate_pivote_row) {
                    $cityId = $delegate_pivote_row['city'];
                    $price = $delegate_pivote_row['price'];
                    $delegate->cities()->attach($cityId, ['price' => $price]);
                }
                
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
    // public function update($delegate_id,$data,$cities)
    // {
    //     try 
    //     {
    //         $delegate = Delegate::findOrFail($delegate_id);

    //         $affectedRows =  $delegate->update($data);

    //         if ($affectedRows > 0) 
    //         {
    //             $delegate->cities()->sync($cities);
    //             return ['code' => 1, 'data' => true];
    //         } 
    //         else 
    //         {
    //             throw new Exception('Error assign delegate');
    //         }
    //     } 
    //     catch (Exception $ex) 
    //     {
    //         return ['code' => 0, 'msg' => $ex->getMessage()];
    //     }
    // }

  
    public function update($data,$delegate)
    {
        try 
        {
            $delegate_table_data = [
                'name' => $data['name'],
                'phone' => $data['phone'],
            ];

            $delegate->update($delegate_table_data);

            
            $delegate_pivote_data = $data['delegates'];
            // Attach delegate to each city with price
            foreach ($delegate_pivote_data as $delegate_pivote_row) {
                $cityId = $delegate_pivote_row['city'];
                $price = $delegate_pivote_row['price'];
                // dd($price);
                $delegate->cities()->syncWithPivotValues($cityId, ['price' => $price]);
            }
            
            return ['code' => 1, 'data' => $delegate];
          
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }


    public function get_delegates_by_city_id($city_id)
    {
        try 
        {
            $city = City::findOrFail($city_id);
            $delegates = $city->delegates;
            if ($delegates->isNotEmpty()) 
            {
                return ['code' => 1 , 'data' => $delegates];
            }
            else 
            {
                throw new Exception("no delegates for selected city");
            }
        }
        catch(Exception $ex)
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }
}
