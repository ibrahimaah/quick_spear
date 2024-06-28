<?php

namespace App\Services;
 
use App\Models\City; 
use Exception; 

class CityService
{
    public function store($data)
    {
        try 
        { 

            $city = City::Create($data);

            if ($city) 
            { 
                return ['code' => 1, 'data' => $city];
            } 
            else 
            {
                throw new Exception('Error in store city');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }


    public function update($data,$city)
    {
        try 
        { 

            $res = $city->update($data);

            if ($res) 
            { 
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error in update city');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }

    public function destroy($city)
    {
        try 
        { 
            $res = $city->delete();

            if ($res) 
            { 
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error in deleting city');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }
  
}
