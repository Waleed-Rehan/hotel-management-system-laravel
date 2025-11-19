<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller {
    public function index(){ return Reservation::with('room','guests')->paginate(); }

    public function store(Request $r){
        $data = $r->validate([
            'room_id'=>'required|exists:rooms,id',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'guest_ids'=>'required|array|min:1',
            'paid_amount'=>'nullable|numeric'
        ]);
        // prevent overlap
        $overlap = Reservation::where('room_id',$data['room_id'])
            ->where(fn($q)=>$q->whereBetween('start_date',[$data['start_date'],$data['end_date']])
                ->orWhereBetween('end_date',[$data['start_date'],$data['end_date']])
                ->orWhere(function($q) use ($data){
                    $q->where('start_date','<=',$data['start_date'])->where('end_date','>=',$data['end_date']);
                }))->exists();
        if($overlap){ return response()->json(['message'=>'Room already reserved for that period'], 422); }

        $res = DB::transaction(function() use ($data, $r){
            $res = Reservation::create([
                'room_id'=>$data['room_id'],
                'start_date'=>$data['start_date'],
                'end_date'=>$data['end_date'],
                'paid_amount'=>$data['paid_amount'] ?? 0,
                'created_by'=>$r->user()->id ?? null
            ]);
            $res->guests()->sync($data['guest_ids']);
            return $res->load('guests','room');
        });
        return $res;
    }

    public function show(Reservation $reservation){ return $reservation->load('room','guests'); }

    public function update(Request $r, Reservation $reservation){
        $reservation->update($r->only('start_date','end_date','paid_amount'));
        if($r->has('guest_ids')){ $reservation->guests()->sync($r->guest_ids); }
        return $reservation->load('room','guests');
    }

    public function destroy(Reservation $reservation){ $reservation->delete(); return response()->noContent(); }

    public function extend(Request $r, Reservation $reservation){
        $days = (int)$r->get('days', 1);
        $reservation->end_date = Carbon::parse($reservation->end_date)->addDays($days);
        $reservation->save();
        return $reservation;
    }

    public function checkin(Request $r, Reservation $reservation){
        $reservation->status = 'checked_in';
        $reservation->save();
        return $reservation;
    }

    public function checkout(Request $r, Reservation $reservation){
        $reservation->status = 'checked_out';
        $reservation->save();
        return $reservation;
    }

    public function calendarDaily(Request $r){
        $date = $r->get('date', Carbon::today()->toDateString());
        return Reservation::with('room')->whereDate('start_date','<=',$date)->whereDate('end_date','>',$date)->get();
    }

    public function calendarRange(Request $r){
        $start = new Carbon($r->get('start'));
        $end = new Carbon($r->get('end'));
        return Reservation::with('room')->where(function($q) use ($start,$end){
            $q->whereBetween('start_date', [$start, $end])
              ->orWhereBetween('end_date', [$start, $end])
              ->orWhere(function($q) use ($start,$end){
                 $q->where('start_date','<=',$start)->where('end_date','>=',$end);
              });
        })->get();
    }
}
