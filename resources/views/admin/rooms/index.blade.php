@extends('admin.layout')

@section('title','الغرف')
@section('page_title','إدارة الغرف')
@section('page_subtitle','عرض، تصفية، وإنشاء غرف جديدة')

@push('head')
  <style>[x-cloak]{display:none!important}</style>
@endpush

@section('content')
  {{-- Flash --}}
  @if(session('ok'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 p-3 text-sm">
      {{ session('ok') }}
    </div>
  @endif

  {{-- Toolbar --}}
  <div class="flex flex-wrap items-end gap-3 bg-white border border-slate-200 p-4 rounded-2xl">
    <form method="GET" class="w-full grid md:grid-cols-5 gap-3">
      <div class="md:col-span-2">
        <label class="text-xs text-slate-500">بحث</label>
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="رقم الغرفة / الحالة / الدور"
               class="w-full rounded-xl border border-slate-200 px-3 py-2">
      </div>

      <div>
        <label class="text-xs text-slate-500">الحالة</label>
        <select name="status" class="w-full rounded-xl border border-slate-200 px-3 py-2">
          <option value="">الكل</option>
          @foreach(\App\Models\Room::STATUSES as $st)
            <option value="{{ $st }}" @selected(($filters['status'] ?? '')===$st)>
              {{ __([
                'vacant'=>'شاغرة','occupied'=>'مشغولة','cleaning'=>'تنظيف',
                'maintenance'=>'صيانة','out_of_service'=>'خارج الخدمة'
              ][$st]) }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="text-xs text-slate-500">نوع الغرفة</label>
        <select name="room_type_id" class="w-full rounded-xl border border-slate-200 px-3 py-2">
          <option value="">الكل</option>
          @foreach($types as $t)
            <option value="{{ $t->id }}" @selected(($filters['room_type_id'] ?? '')==$t->id)>{{ $t->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="text-xs text-slate-500">الدور</label>
        <input type="number" name="floor" value="{{ $filters['floor'] ?? '' }}" class="w-full rounded-xl border border-slate-200 px-3 py-2">
      </div>

      <div class="md:col-span-5 flex justify-end gap-2">
        <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white">مسح</a>
        <button class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white">تطبيق</button>
      </div>
    </form>

    <a href="{{ route('admin.rooms.create') }}"
       class="ml-auto inline-flex items-center px-4 py-2 rounded-xl bg-teal-600 text-white hover:brightness-110">
      + غرفة جديدة
    </a>
  </div>

  {{-- Grid --}}
  <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($rooms as $room)
      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <div class="text-lg font-extrabold">غرفة {{ $room->number }}</div>
          <x-room.status-badge :status="$room->status" />
        </div>
        <div class="mt-2 text-sm text-slate-600">
          <div>الطابق: <span class="font-bold">{{ $room->floor }}</span></div>
          <div>النوع: <span class="font-bold">{{ $room->type?->name ?? '—' }}</span></div>
          <div>السعر: <span class="font-bold">{{ $room->price ? number_format($room->price,2) : '—' }}</span></div>
        </div>
        <div class="mt-4 flex gap-2">
          <a href="{{ route('admin.rooms.edit',$room) }}" class="px-3 py-1.5 rounded-lg bg-amber-500/10 text-amber-700 border border-amber-200 text-sm">تعديل</a>
          <form method="POST" action="{{ route('admin.rooms.destroy',$room) }}"
                onsubmit="return confirm('حذف الغرفة؟');">
            @csrf @method('DELETE')
            <button class="px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-700 border border-rose-200 text-sm">
              حذف
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-span-full rounded-xl bg-white border border-slate-200 p-6 text-center text-slate-500">
        لا توجد غرف مطابقة.
      </div>
    @endforelse
  </div>

  <div class="mt-6">{{ $rooms->links() }}</div>
@endsection
