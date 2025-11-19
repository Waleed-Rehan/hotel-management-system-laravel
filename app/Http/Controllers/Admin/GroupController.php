<?php
// app/Http/Controllers/Admin/GroupController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $q = request('q');
        $groups = \App\Models\Group::query()
            ->when($q, fn($qr) => $qr->where('name','like',"%{$q}%"))
            ->latest()
            ->paginate(12);
    
        return view('admin.groups.index', compact('groups'));
    }
    
    public function create()
    {
        return view('admin.groups.create'); // <-- shows Groups form
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:100'],
            'color' => ['nullable','string','max:20'], // e.g. #10b981 or 'teal'
        ]);

        Group::create($data);

        return redirect()->route('admin.groups.index')
            ->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:100'],
            'color' => ['nullable','string','max:20'],
        ]);

        $group->update($data);

        return redirect()->route('admin.groups.index')
            ->with('success', 'تم تحديث المجموعة بنجاح');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('admin.groups.index')
            ->with('success', 'تم حذف المجموعة');
    }

    public function show( $group)
    {
        $group->load('guests'); // and/or ->loadCount('guests')
        return view('admin.groups.show', compact('group'));
    }
    
}
