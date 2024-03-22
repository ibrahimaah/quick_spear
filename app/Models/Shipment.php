<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function get_status()
    {
        $status = $this->status;
        switch ($status) {
            case 0:
                $statusMsg = 'New';
                break;

            case 1:
                $statusMsg = 'Processing';
                break;

            case 2:
                $statusMsg = 'Delivered';
                break;

            case 3:
                $statusMsg = 'Returned';
                break;

            case 4:
                $statusMsg = 'Pending Payments';
                break;
            case 5:
                $statusMsg = 'Payment Successfully';
                break;

            default:
                $statusMsg = 'Draft';
                break;
        }
        return $statusMsg;
    }

    public function get_status_ar()
    {
        $status = $this->status;
        switch ($status) {
            
            case 0:
                $statusMsg = 'قيد المراجعة';
                break;

            case 1:
                $statusMsg = 'قيد التوصيل';
                break;

            case 2:
                $statusMsg = 'تم التوصيل';
                break;

            case 3:
                $statusMsg = 'رفض الاستلام بدون دفع اجور';
                break;

            case 4:
                $statusMsg = 'رفض الاستلام مع دفع اجور';
                break;
                
            case 5:
                $statusMsg = 'مؤجل';
                break;
                
            case 6:
                $statusMsg = 'لا رد بعد وصول الزبون';
                break;

            case 7:
                $statusMsg = 'مرتجع';
                break;
            
            default:
                $statusMsg = 'قيد المراجعة';
                break;
        }
        return $statusMsg;
    }
}
