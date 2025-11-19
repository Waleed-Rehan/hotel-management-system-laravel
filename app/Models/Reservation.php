<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id','start_date','end_date','status','paid_amount','created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'paid_amount'=> 'decimal:2',
    ];

    // RELATIONSHIPS
    public function room()      { return $this->belongsTo(Room::class); }
    public function guests()    { return $this->belongsToMany(Guest::class)->withTimestamps(); }
    public function creator()   { return $this->belongsTo(User::class, 'created_by'); }

    // SCOPES
    public function scopeBetween($q, $from, $to)
    {
        return $q->where(function($qq) use ($from,$to){
            $qq->whereBetween('start_date', [$from,$to])
               ->orWhereBetween('end_date', [$from,$to])
               ->orWhere(function($q3) use ($from,$to){
                   $q3->where('start_date','<=',$from)->where('end_date','>=',$to);
               });
        });
    }
}
