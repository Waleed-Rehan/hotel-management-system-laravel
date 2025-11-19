<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    protected $fillable = [
        'name', 'capacity', 'beds', 'base_price',
    ];

    /** A room type has many rooms */
    public function rooms(): HasMany
    {
        return $this->hasMany(\App\Models\Room::class);
    }
}
