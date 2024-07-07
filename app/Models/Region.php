<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Region extends Model
{
    use HasFactory;
    public $fillable = ['name','city_id'];
    public $timestamps = false;
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function deliveryPrices(): MorphMany
    {
        return $this->morphMany(DeliveryPrice::class, 'location');
    }
    
}
