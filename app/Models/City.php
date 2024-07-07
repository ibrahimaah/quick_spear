<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class City extends Model
{
    public $guarded = [];
    public $timestamps = false;
    public function delegates(): BelongsToMany
    {
        return $this->belongsToMany(Delegate::class)->withPivot('price')->withTimestamps();
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function deliveryPrices(): MorphMany
    {
        return $this->morphMany(DeliveryPrice::class, 'location');
    }

    
    // public function shipments()
    // {
    //     return $this->hasMany(Shipment::class,'consignee_city','id');
    // }
}
