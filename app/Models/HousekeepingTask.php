<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HousekeepingTask extends Model
{
    protected $fillable = [
        'room_id','notes','needs_food','created_by','completed_at',
    ];

    protected $casts = [
        'needs_food'  => 'boolean',
        'completed_at'=> 'datetime',
    ];

    public function room(){ return $this->belongsTo(Room::class); }
    public function creator(){ return $this->belongsTo(User::class,'created_by'); }

    // حالة مشتقة: مفتوحة/منجزة
    public function getStatusAttribute() { return $this->completed_at ? 'completed' : 'open'; }
}
