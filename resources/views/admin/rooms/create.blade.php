@extends('admin.layout')

@section('title','غرفة جديدة')
@section('page_title','إضافة غرفة')
@section('page_subtitle','إنشاء غرفة جديدة وربطها بنوع محدد')

@section('content')
  @if ($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 text-rose-700 p-3 text-sm">
      <ul class="list-disc pr-6">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.rooms.store') }}"
        class="bg-white border border-slate-200 rounded-2xl p-5 space-y-4">
    @csrf
    <x-room.status-badge status="vacant" class="mb-2" /> {{-- fun touch --}}
    @include('admin.rooms._form', ['types'=>$types, 'statuses'=>$statuses])

    <div class="flex justify-end gap-2 pt-4">
      <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white">إلغاء</a>
      <button class="px-4 py-2 rounded-xl bg-teal-600 text-white">حفظ</button>
    </div>
  </form>
@endsection
