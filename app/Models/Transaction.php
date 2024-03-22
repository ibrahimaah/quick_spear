<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function request()
    {
        return $this->hasOne(PaymentRequest::class, 'transaction_id');
    }

    public function imports()
    {
        return $this->hasMany(ShipmentImport::class, 'transaction_id');
    }

    public function get_status()
    {
        $status = $this->status;
        switch ($status) {
            case 0:
                $statusMsg = 'Processing';
                break;

            case 1:
                $statusMsg = 'Completed';
                break;

            case 2:
                $statusMsg = 'Returned';
                break;

            default:
                $statusMsg = 'Draft';
                break;
        }
        return $statusMsg;
    }
}
