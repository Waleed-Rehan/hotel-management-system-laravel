<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousekeepingTask;
use App\Models\Room;
use Illuminate\Http\Request;

class HousekeepingTaskController extends Controller
{
    public function index()
    {
        $q = request('q');
        $state = request('state'); // open / completed

        $tasks = HousekeepingTask::with(['room:id,number','creator:id,name'])
            ->when($q, fn($qr) =>
                $qr->whereHas('room', fn($r)=>$r->where('number','like',"%{$q}%"))
                   ->orWhere('notes','like',"%{$q}%")
            )
            ->when($state === 'open', fn($qr)=>$qr->whereNull('completed_at'))
            ->when($state === 'completed', fn($qr)=>$qr->whereNotNull('completed_at'))
            ->latest()
            ->paginate(12);

        return view('admin.housekeeping.index', compact('tasks','q','state'));
    }

    public function create()
    {
        $rooms = Room::orderBy('number')->get(['id','number']);
        return view('admin.housekeeping.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'    => ['required','exists:rooms,id'],
            'notes'      => ['nullable','string','max:2000'],
            'needs_food' => ['required','boolean'],
        ]);

        HousekeepingTask::create([
            'room_id'    => $data['room_id'],
            'notes'      => $data['notes'] ?? null,
            'needs_food' => $data['needs_food'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.housekeeping.index')->with('success','تم إضافة مهمة تنظيف.');
    }

    public function show(HousekeepingTask $housekeeping)
    {
        $housekeeping->load(['room','creator']);
        return view('admin.housekeeping.show', ['task'=>$housekeeping]);
    }

    public function edit(HousekeepingTask $housekeeping)
    {
        $rooms = Room::orderBy('number')->get(['id','number']);
        return view('admin.housekeeping.edit', ['task'=>$housekeeping,'rooms'=>$rooms]);
    }

    public function update(Request $request, HousekeepingTask $housekeeping)
    {
        $data = $request->validate([
            'room_id'    => ['required','exists:rooms,id'],
            'notes'      => ['nullable','string','max:2000'],
            'needs_food' => ['required','boolean'],
        ]);

        $housekeeping->update($data);

        return redirect()->route('admin.housekeeping.show',$housekeeping)->with('success','تم التحديث.');
    }

    public function destroy(HousekeepingTask $housekeeping)
    {
        $housekeeping->delete();
        return redirect()->route('admin.housekeeping.index')->with('success','تم الحذف.');
    }

    public function complete(HousekeepingTask $housekeeping)
    {
        if (!$housekeeping->completed_at){
            $housekeeping->update(['completed_at'=>now()]);
        }
        return back()->with('success','تم إنهاء المهمة.');
    }

    public function reopen(HousekeepingTask $housekeeping)
    {
        if ($housekeeping->completed_at){
            $housekeeping->update(['completed_at'=>null]);
        }
        return back()->with('success','تم إعادة فتح المهمة.');
    }
}
