<?php

namespace App\Services;
 
use App\Models\Region; 
use Exception; 

class RegionService
{
    public function store($data)
    {
        try 
        { 

            $region = Region::Create($data);

            if ($region) 
            { 
                return ['code' => 1, 'data' => $region];
            } 
            else 
            {
                throw new Exception('Error in store region');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }


    public function update($data,$region)
    {
        try 
        { 

            $res = $region->update($data);

            if ($res) 
            { 
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error in update region');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }

    public function destroy($region)
    {
        try 
        { 
            $res = $region->delete();

            if ($res) 
            { 
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error in deleting region');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }
  
}
