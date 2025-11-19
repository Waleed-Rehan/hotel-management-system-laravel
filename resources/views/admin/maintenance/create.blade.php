@extends('admin.layout')
@section('title','فتح بلاغ صيانة')
@section('page_title','فتح بلاغ صيانة')

@section('content')
  <form method="POST" action="{{ route('admin.maintenance.store') }}" class="bg-white rounded-2xl border border-slate-200 p-5">
    @csrf
    @include('admin.maintenance._form', ['rooms'=>$rooms])
  </form>
@endsection
