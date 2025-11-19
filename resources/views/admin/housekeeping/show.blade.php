{{-- show: resources/views/admin/housekeeping/show.blade.php --}}
@extends('admin.layout')
@section('title','عرض مهمة تنظيف')
@section('page_title','تفاصيل مهمة التنظيف')
@section('content')
<div class="bg-white rounded-2xl border p-5 text-sm">
  <div class="grid sm:grid-cols-2 gap-4">
    <div><b>الغرفة:</b> #{{ $task->room?->number }}</div>
    <div><b>طعام:</b> {{ $task->needs_food ? 'نعم' : 'لا' }}</div>
    <div class="sm:col-span-2"><b>ملاحظات:</b> {{ $task->notes ?: '—' }}</div>
    <div><b>الحالة:</b> {{ $task->completed_at? 'منجزة' : 'مفتوحة' }}</div>
  </div>
  <div class="mt-5 flex items-center gap-2">
    <a href="{{ route('admin.housekeeping.edit',$task) }}" class="px-4 py-2 rounded-xl bg-amber-100">تعديل</a>
    @if(!$task->completed_at)
      <form method="POST" action="{{ route('admin.housekeeping.complete',$task) }}">@csrf @method('PATCH')
        <button class="px-4 py-2 rounded-xl bg-teal-100">إنهاء</button>
      </form>
    @else
      <form method="POST" action="{{ route('admin.housekeeping.reopen',$task) }}">@csrf @method('PATCH')
        <button class="px-4 py-2 rounded-xl bg-amber-100">إعادة فتح</button>
      </form>
    @endif
  </div>
</div>
@endsection
