<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RoomAsset extends Model {
    protected $fillable = ['room_id','name','is_available'];
    public function room(){ return $this->belongsTo(Room::class); }
}
