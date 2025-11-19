<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function index()
    {
        $q      = trim(request('q', ''));
        $status = request('status');
    
        $reservations = Reservation::query()
            // Avoid N+1: include room number + guest names & blacklist_strikes (for the red flag)
            ->with([
                'room:id,number',
                'guests:id,name',
            ])
            // Search: group OR conditions to keep logic clean
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->whereHas('room', fn ($r) => $r->where('number', 'like', "%{$q}%"))
                      ->orWhereHas('guests', fn ($g) => $g->where('name', 'like', "%{$q}%"))
                      // optional: allow searching by reservation id if user types a number
                      ->orWhere('id', intval($q) ?: -1);
                });
            })
            // Filter by status (only if provided)
            ->when(filled($status), fn ($qr) => $qr->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString(); // keep filters on pagination links
    
        return view('admin.reservations.index', [
            'reservations' => $reservations,
            'filters'      => compact('q', 'status'),
        ]);
    }
    

    public function create()
    {
        return view('admin.reservations.create', [
            'rooms'  => Room::orderBy('number')->get(['id','number']),
            'guests' => Guest::orderBy('name')->get(['id','name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'     => ['required','exists:rooms,id'],
            'start_date'  => ['required','date'],
            'end_date'    => ['required','date','after_or_equal:start_date'],
            'status'      => ['required', Rule::in(['new','confirmed','checked_in','checked_out','canceled'])],
            'paid_amount' => ['nullable','numeric','min:0'],
            'guest_ids'   => ['required','array','min:1'],
            'guest_ids.*' => ['exists:guests,id'],
        ]);

        // منع التداخل: أي حجز لنفس الغرفة يتقاطع مع الفترة المقترحة
        $overlapExists = Reservation::where('room_id', $data['room_id'])
            ->whereNotIn('status', ['canceled','checked_out'])
            ->where(function($q) use ($data) {
                $q->where('start_date', '<=', $data['end_date'])
                  ->where('end_date',   '>=', $data['start_date']);
            })
            ->exists();

        if ($overlapExists) {
            return back()
                ->withErrors(['start_date' => 'الغرفة محجوزة في هذه الفترة. يرجى اختيار فترة أخرى.'])
                ->withInput();
        }

// after $data validated
$blocked = \App\Models\Guest::whereIn('id', $data['guest_ids'])
    ->whereHas('blacklist', fn($q)=>$q->where('active', true))
    ->get();

if ($blocked->isNotEmpty() && ! auth()->user()->hasRole('manager')) {
    return back()
      ->withErrors(['guest_ids' => 'لا يمكن إنشاء الحجز: يوجد ضيف محظور في القائمة السوداء.'])
      ->withInput();
}

// Optional: Manager override notification
if ($blocked->isNotEmpty() && auth()->user()->hasRole('manager')) {
    session()->flash('warning', 'تحذير: الحجز يضم ضيفاً محظوراً. تم السماح به لكونك مديراً.');
}

        $reservation = Reservation::create([
            'room_id'     => $data['room_id'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'status'      => $data['status'],
            'paid_amount' => $data['paid_amount'] ?? 0,
            'created_by'  => auth()->id(),
        ]);

        $reservation->guests()->sync($data['guest_ids']);

        return redirect()
            ->route('admin.reservations.show', $reservation)
            ->with('success','تم إنشاء الحجز بنجاح.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['room','guests','creator']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $reservation->load('guests');
        return view('admin.reservations.edit', [
            'reservation' => $reservation,
            'rooms'       => Room::orderBy('number')->get(['id','number']),
            'guests'      => Guest::orderBy('name')->get(['id','name']),
        ]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'room_id'     => ['required','exists:rooms,id'],
            'start_date'  => ['required','date'],
            'end_date'    => ['required','date','after_or_equal:start_date'],
            'status'      => ['required', Rule::in(['new','confirmed','checked_in','checked_out','canceled'])],
            'paid_amount' => ['nullable','numeric','min:0'],
            'guest_ids'   => ['required','array','min:1'],
            'guest_ids.*' => ['exists:guests,id'],
        ]);

        // منع التداخل مع استثناء هذا الحجز الحالي
        $overlapExists = Reservation::where('room_id', $data['room_id'])
            ->where('id', '!=', $reservation->id)
            ->whereNotIn('status', ['canceled','checked_out'])
            ->where(function($q) use ($data) {
                $q->where('start_date', '<=', $data['end_date'])
                  ->where('end_date',   '>=', $data['start_date']);
            })
            ->exists();

        if ($overlapExists) {
            return back()
                ->withErrors(['start_date' => 'الغرفة محجوزة في هذه الفترة. يرجى اختيار فترة أخرى.'])
                ->withInput();
        }

// after $data validated
$blocked = \App\Models\Guest::whereIn('id', $data['guest_ids'])
    ->whereHas('blacklist', fn($q)=>$q->where('active', true))
    ->get();

if ($blocked->isNotEmpty() && ! auth()->user()->hasRole('manager')) {
    return back()
      ->withErrors(['guest_ids' => 'لا يمكن إنشاء الحجز: يوجد ضيف محظور في القائمة السوداء.'])
      ->withInput();
}

// Optional: Manager override notification
if ($blocked->isNotEmpty() && auth()->user()->hasRole('manager')) {
    session()->flash('warning', 'تحذير: الحجز يضم ضيفاً محظوراً. تم السماح به لكونك مديراً.');
}

        $reservation->update([
            'room_id'     => $data['room_id'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'status'      => $data['status'],
            'paid_amount' => $data['paid_amount'] ?? 0,
        ]);

        $reservation->guests()->sync($data['guest_ids']);

        return redirect()
            ->route('admin.reservations.show', $reservation)
            ->with('success','تم تحديث الحجز.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success','تم حذف الحجز.');
    }
}
