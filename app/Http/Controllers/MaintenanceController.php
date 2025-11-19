<?php
namespace App\Http\Controllers;
use App\Models\MaintenanceTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceController extends Controller {
    public function index(){ return MaintenanceTicket::with('room')->latest()->paginate(); }
    public function store(Request $r){
        $ticket = MaintenanceTicket::create($r->only('room_id','issue') + ['created_by'=>$r->user()->id ?? null, 'status'=>'open']);
        return $ticket->load('room');
    }
    public function update(Request $r, MaintenanceTicket $maintenance){
        $maintenance->update($r->only('issue','status'));
        return $maintenance;
    }
    public function requestTools(MaintenanceTicket $ticket, Request $r){
        $ticket->tools_request = $r->get('tools_request');
        $ticket->save();
        return $ticket;
    }
    public function complete(MaintenanceTicket $ticket){
        $ticket->status = 'done';
        $ticket->completed_at = Carbon::now();
        $ticket->save();
        return $ticket;
    }
}
