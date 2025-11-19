<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceTicket;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceTicketController extends Controller
{
    public function index()
    {
        $q = request('q');
        $status = request('status'); // open,in_progress,on_hold,closed

        $tickets = MaintenanceTicket::with(['room:id,number','creator:id,name'])
            ->when($q, fn($qr) =>
                $qr->whereHas('room', fn($r)=>$r->where('number','like',"%{$q}%"))
                   ->orWhere('issue','like',"%{$q}%")
                   ->orWhere('tools_request','like',"%{$q}%")
            )
            ->when($status, fn($qr)=>$qr->where('status',$status))
            ->latest()
            ->paginate(12);

        return view('admin.maintenance.index', compact('tickets','q','status'));
    }

    public function create()
    {
        $rooms = Room::orderBy('number')->get(['id','number']);
        return view('admin.maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'       => ['required','exists:rooms,id'],
            'issue'         => ['required','string','max:5000'],
            'tools_request' => ['nullable','string','max:2000'],
            'status'        => ['required', Rule::in(['open','in_progress','on_hold','closed'])],
        ]);

        $ticket = MaintenanceTicket::create([
            'room_id'       => $data['room_id'],
            'issue'         => $data['issue'],
            'tools_request' => $data['tools_request'] ?? null,
            'status'        => $data['status'],
            'created_by'    => auth()->id(),
            'completed_at'  => $data['status']==='closed' ? now() : null,
        ]);

        return redirect()->route('admin.maintenance.show',$ticket)->with('success','تم فتح بلاغ صيانة.');
    }

    public function show(MaintenanceTicket $maintenance)
    {
        $maintenance->load(['room','creator']);
        return view('admin.maintenance.show', ['ticket'=>$maintenance]);
    }

    public function edit(MaintenanceTicket $maintenance)
    {
        $rooms = Room::orderBy('number')->get(['id','number']);
        return view('admin.maintenance.edit', ['ticket'=>$maintenance,'rooms'=>$rooms]);
    }

    public function update(Request $request, MaintenanceTicket $maintenance)
    {
        $data = $request->validate([
            'room_id'       => ['required','exists:rooms,id'],
            'issue'         => ['required','string','max:5000'],
            'tools_request' => ['nullable','string','max:2000'],
            'status'        => ['required', Rule::in(['open','in_progress','on_hold','closed'])],
        ]);

        $maintenance->update([
            'room_id'       => $data['room_id'],
            'issue'         => $data['issue'],
            'tools_request' => $data['tools_request'] ?? null,
            'status'        => $data['status'],
            'completed_at'  => $data['status']==='closed' ? now() : null,
        ]);

        return redirect()->route('admin.maintenance.show',$maintenance)->with('success','تم تحديث البلاغ.');
    }

    public function destroy(MaintenanceTicket $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('admin.maintenance.index')->with('success','تم حذف البلاغ.');
    }

    public function close(MaintenanceTicket $maintenance)
    {
        if ($maintenance->status !== 'closed') {
            $maintenance->update(['status'=>'closed','completed_at'=>now()]);
        }
        return back()->with('success','تم إغلاق البلاغ.');
    }

    public function reopen(MaintenanceTicket $maintenance)
    {
        if ($maintenance->status === 'closed') {
            $maintenance->update(['status'=>'open','completed_at'=>null]);
        }
        return back()->with('success','تم إعادة فتح البلاغ.');
    }
}
