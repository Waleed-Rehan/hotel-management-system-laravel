<?php
namespace App\Http\Controllers;
use App\Models\Group;
use App\Models\Reservation;

class GroupController extends Controller {
    public function index(){ return Group::paginate(); }
    public function store(){ request()->validate(['name'=>'required','color'=>'nullable']); return Group::create(request()->only('name','color')); }
    public function show(Group $group){ return $group->load('guests'); }
    public function roomsCount(Group $group){
        // count rooms reserved by guests of this group (distinct rooms)
        $guestIds = $group->guests()->pluck('id');
        $roomIds = Reservation::whereHas('guests', fn($q)=>$q->whereIn('guests.id',$guestIds))->pluck('room_id')->unique()->values();
        return ['count' => $roomIds->count()];
    }
}
