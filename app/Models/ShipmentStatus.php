<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    use HasFactory; 

    protected $table = 'shipment_statuses';

    const UNDER_REVIEW = 1;
    const UNDER_DELIVERY = 2;
    const DELIVERED = 3;
    const REJECTED_WITHOUT_PAY = 4;
    const REJECTED_WITH_PAY = 5;
    const POSTPONED = 6;
    const NO_RESPONSE = 7; 
    const CANCELED = 8; 
}
