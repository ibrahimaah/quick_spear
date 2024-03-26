<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

}
