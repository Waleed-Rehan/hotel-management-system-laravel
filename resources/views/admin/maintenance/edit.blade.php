@extends('admin.layout')
@section('title','تعديل بلاغ صيانة')
@section('page_title','تعديل بلاغ صيانة')

@section('content')
  <form method="POST" action="{{ route('admin.maintenance.update',$ticket) }}" class="bg-white rounded-2xl border border-slate-200 p-5">
    @csrf @method('PUT')
    @include('admin.maintenance._form', ['ticket'=>$ticket,'rooms'=>$rooms])
  </form>
@endsection
