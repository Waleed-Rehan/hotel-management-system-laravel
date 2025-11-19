@extends('admin.layout')

@section('title','تعديل نوع غرفة')
@section('page_title','تعديل نوع غرفة')

@section('content')
  @if($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 text-rose-800 px-4 py-3 text-sm">
      <ul class="list-disc pr-6">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.room-types.update', $type) }}"
        class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf @method('PUT')
    @include('admin.room-types._form', ['type' => $type])
  </form>
@endsection
