<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    use HasFactory; 

    const UNDER_REVIEW = 0;
    const UNDER_DELIVERY = 1;
    const DELIVERED = 2;
    const REJECTED_WITHOUT_PAY = 3;
    const REJECTED_WITH_PAY = 4;
    const POSTPONED = 5;
    const NO_RESPONSE = 6;
    const RETURNED = 7;
}
