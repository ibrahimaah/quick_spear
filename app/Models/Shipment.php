<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    public $guarded = [];
    protected $appends = ['notes'];

    public function getNotesAttribute()
    {
        if ($this->customer_notes && $this->delegate_notes) 
            {
                return $this->customer_notes .' - '.$this->delegate_notes;
            }
            elseif ($this->customer_notes && !$this->delegate_notes) 
            {
                return $this->customer_notes;
            }
            elseif (!$this->customer_notes && $this->delegate_notes) 
            {
                return $this->delegate_notes;
            }
            else 
            {
                return 'لا يوجد';
            }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function city_to()
    {
        return $this->belongsTo(City::class, 'consignee_city');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // public function get_status()
    // {
    //     $status = $this->status;
    //     switch ($status) {
    //         case 0:
    //             $statusMsg = 'New';
    //             break;

    //         case 1:
    //             $statusMsg = 'Processing';
    //             break;

    //         case 2:
    //             $statusMsg = 'Delivered';
    //             break;

    //         case 3:
    //             $statusMsg = 'Returned';
    //             break;

    //         case 4:
    //             $statusMsg = 'Pending Payments';
    //             break;
    //         case 5:
    //             $statusMsg = 'Payment Successfully';
    //             break;

    //         default:
    //             $statusMsg = 'Draft';
    //             break;
    //     }
    //     return $statusMsg;
    // }

    public function get_status()
    {
        $status = $this->status;
        $status_numbers = config('constants.STATUS_NUMBER');
        switch ($status) {
            case $status_numbers['UNDER_REVIEW']:
                return __('under_review');
            case $status_numbers['UNDER_DELIVERY']:
                return __('under_delivery');
            case $status_numbers['DELIVERED']:
                return __('delivered');
            case $status_numbers['REJECTED_WITHOUT_PAY']:
                return __('rejected_without_pay');
            case $status_numbers['REJECTED_WITH_PAY']:
                return __('rejected_with_pay');
            case $status_numbers['POSTPONED']:
                return __('postponed');
            case  $status_numbers['NO_RESPONSE']:
                return __('no_response');
            // case $status_numbers['RETURNED']:
            //     return __('returned');
            default:
                return __('unknown_status');
        }
    }

    public function delegate(): BelongsTo
    {
        return $this->belongsTo(Delegate::class);
    }
}
