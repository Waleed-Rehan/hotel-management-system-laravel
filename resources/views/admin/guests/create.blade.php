@extends('admin.layout')
@section('title','ضيف جديد')
@section('page_title','ضيف جديد')

@section('content')
  <form method="POST" action="{{ route('admin.guests.store') }}" class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf
    @include('admin.guests._form', ['groups'=>$groups])
  </form>
@endsection
