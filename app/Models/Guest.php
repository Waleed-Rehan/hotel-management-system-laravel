<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    
    protected $fillable = [
        'name','nationality','document_type','document_number','group_id',
    ];
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    // App/Models/Guest.php
public function incidents() { return $this->hasMany(\App\Models\GuestIncident::class); }

}
