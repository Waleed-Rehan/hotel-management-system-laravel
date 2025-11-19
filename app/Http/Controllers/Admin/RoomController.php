<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    private array $statuses = ['vacant','occupied','cleaning','maintenance','out_of_service'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['q','status','room_type_id','floor']);

        $rooms = Room::with('type')
            ->when($filters['q'] ?? null, function ($q, $v) {
                $q->where(fn($w) =>
                    $w->where('number', 'like', "%{$v}%")
                      ->orWhere('status', 'like', "%{$v}%")
                      ->orWhere('floor', $v)
                );
            })
            ->when($filters['status'] ?? null, fn($q,$v) => $q->where('status',$v))
            ->when($filters['room_type_id'] ?? null, fn($q,$v) => $q->where('room_type_id',$v))
            ->when($filters['floor'] ?? null, fn($q,$v) => $q->where('floor',$v))
            ->orderBy('floor')->orderBy('number')
            ->paginate(12)->withQueryString();

        $types = RoomType::orderBy('name')->get(['id','name']);

        return view('admin.rooms.index', compact('rooms','types','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = RoomType::orderBy('name')->get(['id','name']);
        $statuses = $this->statuses;

        return view('admin.rooms.create', compact('types','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'number'       => ['required','string','max:50','unique:rooms,number'],
            'floor'        => ['required','integer','min:0'],
            'room_type_id' => ['required','exists:room_types,id'],
            'status'       => ['required', Rule::in($this->statuses)],
            'price'        => ['nullable','numeric','min:0','max:9999999999.99'],
        ]);

        Room::create($data);

        return redirect()->route('admin.rooms.index')
            ->with('ok','تم إنشاء الغرفة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        // Optional: show single room card/details
        $room->load('type');
        return view('admin.rooms.show', compact('room'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $types = RoomType::orderBy('name')->get(['id','name']);
        $statuses = $this->statuses;

        return view('admin.rooms.edit', compact('room','types','statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'number'       => ['required','string','max:50', Rule::unique('rooms','number')->ignore($room->id)],
            'floor'        => ['required','integer','min:0'],
            'room_type_id' => ['required','exists:room_types,id'],
            'status'       => ['required', Rule::in($this->statuses)],
            'price'        => ['nullable','numeric','min:0','max:9999999999.99'],
        ]);

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('ok','تم تحديث بيانات الغرفة.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return back()->with('ok','تم حذف الغرفة.');
    }
}
