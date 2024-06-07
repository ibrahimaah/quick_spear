<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delegate extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','city_id'];

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    // public function cities(): HasMany
    // {
    //     return $this->hasMany(City::class);
    // }

    // public function City()
    // {
    //     return $this->belongsTo(City::class);
    // }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class)->withTimestamps();
    }
}
