<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = ['name','color'];

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
