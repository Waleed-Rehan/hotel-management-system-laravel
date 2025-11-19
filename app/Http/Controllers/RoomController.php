<?php
namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller {
    public function index(){ return Room::with('type')->paginate(); }
    public function store(Request $r){ return Room::create($r->only('number','floor','room_type_id','status','price')); }
    public function show(Room $room){ return $room->load('type','assets'); }
    public function update(Request $r, Room $room){ $room->update($r->only('number','floor','room_type_id','status','price')); return $room; }
    public function destroy(Room $room){ $room->delete(); return response()->noContent(); }
}
