@extends('admin.layout')

@section('title','المجموعات')
@section('page_title','المجموعات')
@section('page_subtitle','إدارة مجموعات الضيوف')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  {{-- Toolbar --}}
  <div class="mb-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 justify-between">
    <form method="GET" class="flex items-center gap-2">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن مجموعة…"
             class="rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
      <button class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">بحث</button>
      @if(request('q'))
        <a href="{{ route('admin.groups.index') }}" class="text-sm text-slate-500 hover:underline">مسح البحث</a>
      @endif
    </form>

    <a href="{{ route('admin.groups.create') }}"
       class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">مجموعة جديدة</a>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
    <table class="w-full text-sm">
      <thead class="bg-slate-50">
        <tr class="text-right">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">الاسم</th>
          <th class="px-4 py-3">اللون</th>
          <th class="px-4 py-3 w-40">العمليات</th>
        </tr>
      </thead>
      <tbody>
      @forelse($groups as $group)
        <tr class="border-t">
          <td class="px-4 py-3">{{ $group->id }}</td>

          <td class="px-4 py-3">
            <a href="{{ route('admin.groups.show',$group) }}"
               class="text-teal-700 hover:underline">{{ $group->name }}</a>
          </td>

          <td class="px-4 py-3">
            @if (view()->exists('components.group.badge'))
              <x-group.badge :name="$group->name" :color="$group->color" />
            @else
              <span class="inline-flex items-center gap-2">
                <span class="inline-block w-4 h-4 rounded" style="background: {{ $group->color ?? '#e2e8f0' }}"></span>
                <span class="text-slate-500">{{ $group->color ?? '—' }}</span>
              </span>
            @endif
          </td>

          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <a href="{{ route('admin.groups.edit',$group) }}"
                 class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs">تعديل</a>
              <form method="POST" action="{{ route('admin.groups.destroy',$group) }}"
                    onsubmit="return confirm('حذف المجموعة؟');">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs">
                  حذف
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-4 py-6 text-center text-slate-500">لا توجد مجموعات.</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $groups->withQueryString()->links() }}</div>
@endsection
