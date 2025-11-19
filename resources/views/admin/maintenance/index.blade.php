@extends('admin.layout')
@section('title','الصيانة')
@section('page_title','بلاغات الصيانة')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  <div class="mb-4 flex items-center justify-between gap-3">
    <form method="GET" class="flex flex-wrap items-center gap-2">
      <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="بحث (الغرفة/المشكلة/الأدوات)"
             class="rounded-xl border border-slate-200 px-3 py-2">
      <select name="status" class="rounded-xl border border-slate-200 px-3 py-2">
        <option value="">كل الحالات</option>
        @php $statuses = ['open'=>'مفتوح','in_progress'=>'قيد التنفيذ','on_hold'=>'معلّق','closed'=>'مغلق']; @endphp
        @foreach($statuses as $key=>$label)
          <option value="{{ $key }}" @selected(($status ?? '')===$key)>{{ $label }}</option>
        @endforeach
      </select>
      <button class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">تصفية</button>
    </form>

    <a href="{{ route('admin.maintenance.create') }}"
       class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">
      فتح بلاغ
    </a>
  </div>

  <div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
    <table class="w-full text-sm">
      <thead class="bg-slate-50">
        <tr class="text-right">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">الغرفة</th>
          <th class="px-4 py-3">المشكلة</th>
          <th class="px-4 py-3">الأدوات المطلوبة</th>
          <th class="px-4 py-3">الحالة</th>
          <th class="px-4 py-3">المُنشئ</th>
          <th class="px-4 py-3">العمليات</th>
        </tr>
      </thead>
      <tbody>
      @forelse($tickets as $t)
        <tr class="border-t">
          <td class="px-4 py-3">{{ $t->id }}</td>
          <td class="px-4 py-3">#{{ $t->room?->number }}</td>
          <td class="px-4 py-3 max-w-[360px] truncate" title="{{ $t->issue }}">{{ $t->issue }}</td>
          <td class="px-4 py-3 max-w-[280px] truncate" title="{{ $t->tools_request }}">{{ $t->tools_request ?: '—' }}</td>
          <td class="px-4 py-3">
            @php
              $map = [
                'open' => 'bg-amber-50 text-amber-700',
                'in_progress' => 'bg-sky-50 text-sky-700',
                'on_hold' => 'bg-slate-100 text-slate-700',
                'closed' => 'bg-teal-50 text-teal-700',
              ];
              $label = [
                'open'=>'مفتوح', 'in_progress'=>'قيد التنفيذ', 'on_hold'=>'معلّق', 'closed'=>'مغلق'
              ][$t->status] ?? $t->status;
            @endphp
            <span class="px-2 py-1 rounded-lg text-xs {{ $map[$t->status] ?? 'bg-slate-100 text-slate-700' }}">
              {{ $label }}
            </span>
          </td>
          <td class="px-4 py-3">{{ $t->creator?->name ?: '—' }}</td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <a href="{{ route('admin.maintenance.show',$t) }}" class="text-teal-700 hover:underline">عرض</a>
              <a href="{{ route('admin.maintenance.edit',$t) }}" class="text-amber-700 hover:underline">تعديل</a>

              @if($t->status !== 'closed')
                <form method="POST" action="{{ route('admin.maintenance.close',$t) }}" class="inline">@csrf @method('PATCH')
                  <button class="text-teal-700 hover:underline">إغلاق</button>
                </form>
              @else
                <form method="POST" action="{{ route('admin.maintenance.reopen',$t) }}" class="inline">@csrf @method('PATCH')
                  <button class="text-amber-700 hover:underline">إعادة فتح</button>
                </form>
              @endif

              <form method="POST" action="{{ route('admin.maintenance.destroy',$t) }}" class="inline" onsubmit="return confirm('حذف البلاغ؟');">
                @csrf @method('DELETE')
                <button class="text-rose-700 hover:underline">حذف</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="px-4 py-6 text-center text-slate-500">لا توجد بلاغات صيانة.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $tickets->withQueryString()->links() }}</div>
@endsection
