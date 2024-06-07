<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    public $guarded = [];

    public function delegates(): BelongsToMany
    {
        return $this->belongsToMany(Delegate::class)->withTimestamps();
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
}
