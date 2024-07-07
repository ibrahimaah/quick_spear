<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPrice extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id','location_type','location_id','price'];
    public function location()
    {
        return $this->morphTo();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }


}
