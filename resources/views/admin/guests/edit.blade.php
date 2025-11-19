@extends('admin.layout')
@section('title','تعديل ضيف')
@section('page_title','تعديل ضيف')

@section('content')
  <form method="POST" action="{{ route('admin.guests.update', $guest) }}" class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf @method('PUT')
    @include('admin.guests._form', ['guest'=>$guest,'groups'=>$groups])
  </form>
@endsection
