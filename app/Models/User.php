<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    // Allow email + the rest to be mass assigned
    protected $fillable = [
        'name',
        'email',        // <-- add this
        'username',
        'password',
        'national_id',
        'phone',
        'birthdate',
        'address',
        'job_title',
        'start_date',
        'end_date',
    ];

    protected $hidden = ['password','remember_token'];

    // Helpful casts (optional but nice)
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate'         => 'date',
        'start_date'        => 'date',
        'end_date'          => 'date',
        // If you want Laravel to auto-hash when setting password:
        // 'password'       => 'hashed',
    ];
}
