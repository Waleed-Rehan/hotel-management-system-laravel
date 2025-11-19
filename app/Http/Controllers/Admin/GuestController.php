<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Group;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $q        = $request->string('q');
        $group_id = $request->integer('group_id');

        $guests = Guest::query()
            ->with('group')
            ->when($q, function($qr) use ($q) {
                $qr->where(function($x) use ($q){
                    $x->where('name','like',"%{$q}%")
                      ->orWhere('document_number','like',"%{$q}%")
                      ->orWhere('nationality','like',"%{$q}%");
                });
            })
            ->when($group_id, fn($qr) => $qr->where('group_id',$group_id))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $groups = Group::orderBy('name')->get(['id','name','color']);

        return view('admin.guests.index', compact('guests','groups','q','group_id'));
    }

    public function create()
    {
        $groups = Group::orderBy('name')->get(['id','name','color']);
        return view('admin.guests.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => ['required','string','max:255'],
            'nationality'      => ['nullable','string','max:100'],
            'document_type'    => ['nullable','in:id,passport'],
            'document_number'  => ['nullable','string','max:100'],
            'group_id'         => ['nullable','exists:groups,id'],
        ]);

        Guest::create($data);

        return redirect()->route('admin.guests.index')->with('success','تم إضافة الضيف.');
    }

    public function quickStore(Request $request)
{
    $data = $request->validate([
        'name'             => ['required', 'string', 'max:255'],
        'nationality'      => ['nullable', 'string', 'max:120'],
        'document_type'    => ['nullable', Rule::in(['id','passport'])],
        'document_number'  => ['nullable', 'string', 'max:120'],
    ]);

    $guest = \App\Models\Guest::create([
        'name'             => $data['name'],
        'nationality'      => $data['nationality'] ?? null,
        'document_type'    => $data['document_type'] ?? null,
        'document_number'  => $data['document_number'] ?? null,
        // default strikes 0 (per migration), group_id null
    ]);

    return response()->json([
        'id'             => $guest->id,
        'name'           => $guest->name,
    ]);
}


    public function show(Guest $guest)
    {
        $guest->load('group');
        return view('admin.guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        $groups = Group::orderBy('name')->get(['id','name','color']);
        return view('admin.guests.edit', compact('guest','groups'));
    }

    public function update(Request $request, Guest $guest)
    {
        $data = $request->validate([
            'name'             => ['required','string','max:255'],
            'nationality'      => ['nullable','string','max:100'],
            'document_type'    => ['nullable','in:id,passport'],
            'document_number'  => ['nullable','string','max:100'],
            'group_id'         => ['nullable','exists:groups,id'],
        ]);

        $guest->update($data);

        return redirect()->route('admin.guests.index')->with('success','تم تحديث بيانات الضيف.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('admin.guests.index')->with('success','تم حذف الضيف.');
    }
}
