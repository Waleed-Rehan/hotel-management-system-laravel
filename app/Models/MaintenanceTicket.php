<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTicket extends Model
{
    protected $fillable = [
        'room_id','issue','tools_request','status','created_by','completed_at',
    ];

    protected $casts = [
        'completed_at'=> 'datetime',
    ];

    public function room(){ return $this->belongsTo(Room::class); }
    public function creator(){ return $this->belongsTo(User::class,'created_by'); }
}
