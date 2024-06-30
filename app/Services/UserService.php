<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;

class UserService
{
    public function store($data)
    {
        try 
        {
            $user = User::Create($data);

            if ($user) 
            { 
                return ['code' => 1, 'data' => $user];
            } 
            else 
            {
                throw new Exception('Error store user');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }



    public function update_pwd($new_pwd,User $user)
    {
        try 
        {
            $user->password = $new_pwd;

            if ($user->save()) 
            { 
                return ['code' => 1, 'data' => true];
            } 
            else 
            {
                throw new Exception('Error in updating user password');
            }
        } 
        catch (Exception $ex) 
        {
            return ['code' => 0, 'msg' => $ex->getMessage()];
        }
    }
    
    
    
  

}
