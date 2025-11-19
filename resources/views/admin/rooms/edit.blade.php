@extends('admin.layout')

@section('title','تعديل غرفة')
@section('page_title','تعديل غرفة '.$room->number)
@section('page_subtitle','تحديث بيانات الغرفة')

@section('content')
  @if ($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 text-rose-700 p-3 text-sm">
      <ul class="list-disc pr-6">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.rooms.update',$room) }}"
        class="bg-white border border-slate-200 rounded-2xl p-5 space-y-4">
    @csrf @method('PUT')
    <x-room.status-badge :status="$room->status" class="mb-2" />
    @include('admin.rooms._form', ['room'=>$room, 'types'=>$types, 'statuses'=>$statuses])

    <div class="flex justify-between items-center pt-4">
      <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white">رجوع</a>

      <div class="flex gap-2">
        <form method="POST" action="{{ route('admin.rooms.destroy',$room) }}"
              onsubmit="return confirm('حذف الغرفة؟');">
          @csrf @method('DELETE')
          <button class="px-4 py-2 rounded-xl bg-rose-600 text-white">حذف</button>
        </form>
        <button class="px-4 py-2 rounded-xl bg-teal-600 text-white">حفظ</button>
      </div>
    </div>
  </form>
@endsection
