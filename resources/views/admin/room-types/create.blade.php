@extends('admin.layout')

@section('title','نوع غرفة جديد')
@section('page_title','نوع غرفة جديد')

@section('content')
  @if($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 text-rose-800 px-4 py-3 text-sm">
      <ul class="list-disc pr-6">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.room-types.store') }}"
        class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf
    @include('admin.room-types._form')
  </form>
@endsection
