<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model

{

    protected $fillable = ['number','floor','room_type_id','status','price'];

    public const STATUSES = ['vacant','occupied','cleaning','maintenance','out_of_service'];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    // Simple scope filters
    public function scopeFilter($q, array $filters)
    {
        $q->when($filters['q'] ?? null, fn($qq,$v) =>
            $qq->where(function($w) use ($v){
                $w->where('number','like',"%$v%")
                  ->orWhere('floor',$v)
                  ->orWhere('status','like',"%$v%");
            })
        );

        $q->when($filters['status'] ?? null, fn($qq,$v)=> $qq->where('status',$v));
        $q->when($filters['room_type_id'] ?? null, fn($qq,$v)=> $qq->where('room_type_id',$v));
        $q->when($filters['floor'] ?? null, fn($qq,$v)=> $qq->where('floor',$v));
    }
    // App\Models\Room.php


}
