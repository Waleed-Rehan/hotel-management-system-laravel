@extends('admin.layout')

@section('title','حجز جديد')
@section('page_title','حجز جديد')

@section('content')
  <form method="POST" action="{{ route('admin.reservations.store') }}"
        class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf
    @include('admin.reservations._form')
  </form>
@endsection
