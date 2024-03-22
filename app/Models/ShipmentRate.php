<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentRate extends Model
{
    public $guarded = [];

    public function city_r_from()
    {
        return $this->belongsTo(City::class, 'city_from');
    }

    public function city_r_to()
    {
        return $this->belongsTo(City::class, 'city_to');
    }
}
