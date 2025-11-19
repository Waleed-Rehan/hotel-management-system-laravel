<?php
namespace App\Http\Controllers;
use App\Models\HousekeepingTask;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HousekeepingController extends Controller {
    public function index(){ return HousekeepingTask::with('room')->latest()->paginate(); }
    public function store(Request $r){
        $task = HousekeepingTask::create($r->only('room_id','notes','needs_food') + ['created_by'=>$r->user()->id ?? null]);
        return $task->load('room');
    }
    public function update(Request $r, HousekeepingTask $housekeeping){
        $housekeeping->update($r->only('notes','needs_food'));
        return $housekeeping;
    }
    public function complete(HousekeepingTask $task){
        $task->completed_at = Carbon::now();
        $task->save();
        return $task;
    }
}
