<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delegate extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone'];

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
