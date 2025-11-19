<?php
namespace App\Http\Controllers;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller {
    public function index(){ return RoomType::paginate(); }
    public function store(Request $r){ return RoomType::create($r->only('name','capacity','beds','base_price')); }
    public function show(RoomType $room_type){ return $room_type; }
    public function update(Request $r, RoomType $room_type){ $room_type->update($r->only('name','capacity','beds','base_price')); return $room_type; }
    public function destroy(RoomType $room_type){ $room_type->delete(); return response()->noContent(); }
}
