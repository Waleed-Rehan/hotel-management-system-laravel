<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /** List */
    public function index()
    {
        $types = RoomType::query()
            ->withCount('rooms')
            ->latest('id')
            ->paginate(12);

        return view('admin.room-types.index', compact('types'));
    }

    /** Create form */
    public function create()
    {
        return view('admin.room-types.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required','string','max:255'],
            'capacity'   => ['required','integer','min:1'],
            'beds'       => ['required','integer','min:1'],
            'base_price' => ['required','numeric','min:0'],
        ]);

        RoomType::create($data);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'تم إنشاء نوع الغرفة بنجاح.');
    }

    /** Show one */
    public function show(RoomType $room_type)
    {
        $room_type->loadCount('rooms');
        return view('admin.room-types.show', ['type' => $room_type]);
    }

    /** Edit form */
    public function edit(RoomType $room_type)
    {
        return view('admin.room-types.edit', ['type' => $room_type]);
    }

    /** Update */
    public function update(Request $request, RoomType $room_type)
    {
        $data = $request->validate([
            'name'       => ['required','string','max:255'],
            'capacity'   => ['required','integer','min:1'],
            'beds'       => ['required','integer','min:1'],
            'base_price' => ['required','numeric','min:0'],
        ]);

        $room_type->update($data);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'تم تحديث نوع الغرفة بنجاح.');
    }

    /** Delete */
    public function destroy(RoomType $room_type)
    {
        $room_type->delete();

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'تم حذف نوع الغرفة.');
    }
}
