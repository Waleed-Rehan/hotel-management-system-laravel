@extends('admin.layout')
@section('title','التنظيف')
@section('page_title','مهام التنظيف')
@section('content')

<div class="mb-4 flex items-center justify-between gap-3">
  <form method="GET" class="flex items-center gap-2">
    <input type="text" name="q" value="{{ $q }}" placeholder="بحث (الغرفة/الملاحظات)"
           class="rounded-xl border border-slate-200 px-3 py-2">
    <select name="state" class="rounded-xl border border-slate-200 px-3 py-2">
      <option value="">الكل</option>
      <option value="open" @selected($state==='open')>مفتوحة</option>
      <option value="completed" @selected($state==='completed')>منجزة</option>
    </select>
    <button class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white">تصفية</button>
  </form>
  <a href="{{ route('admin.housekeeping.create') }}" class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white">مهمة جديدة</a>
</div>

<div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
  <table class="w-full text-sm">
    <thead class="bg-slate-50">
      <tr class="text-right">
        <th class="px-4 py-3">#</th>
        <th class="px-4 py-3">الغرفة</th>
        <th class="px-4 py-3">ملاحظات</th>
        <th class="px-4 py-3">طعام؟</th>
        <th class="px-4 py-3">الحالة</th>
        <th class="px-4 py-3">العمليات</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tasks as $t)
      <tr class="border-t">
        <td class="px-4 py-3">{{ $t->id }}</td>
        <td class="px-4 py-3">غرفة #{{ $t->room?->number }}</td>
        <td class="px-4 py-3 truncate max-w-[340px]">{{ $t->notes }}</td>
        <td class="px-4 py-3">{{ $t->needs_food ? 'نعم' : 'لا' }}</td>
        <td class="px-4 py-3">
          <span class="px-2 py-1 rounded-lg text-xs {{ $t->completed_at ? 'bg-teal-50 text-teal-700' : 'bg-amber-50 text-amber-700' }}">
            {{ $t->completed_at ? 'منجزة' : 'مفتوحة' }}
          </span>
        </td>
        <td class="px-4 py-3">
          <div class="flex items-center gap-2">
            <a href="{{ route('admin.housekeeping.show',$t) }}" class="text-teal-700 hover:underline">عرض</a>
            <a href="{{ route('admin.housekeeping.edit',$t) }}" class="text-amber-700 hover:underline">تعديل</a>
            @if(!$t->completed_at)
              <form method="POST" action="{{ route('admin.housekeeping.complete',$t) }}">@csrf @method('PATCH')
                <button class="text-teal-700 hover:underline">إنهاء</button>
              </form>
            @else
              <form method="POST" action="{{ route('admin.housekeeping.reopen',$t) }}">@csrf @method('PATCH')
                <button class="text-amber-700 hover:underline">إعادة فتح</button>
              </form>
            @endif
            <form method="POST" action="{{ route('admin.housekeeping.destroy',$t) }}" onsubmit="return confirm('حذف?');">
              @csrf @method('DELETE')
              <button class="text-rose-700 hover:underline">حذف</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="px-4 py-6 text-center text-slate-500">لا توجد مهام.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $tasks->withQueryString()->links() }}</div>
@endsection
