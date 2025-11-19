@extends('admin.layout')

@section('title','مجموعة جديدة')
@section('page_title','مجموعة جديدة')

@section('content')
  <form method="POST" action="{{ route('admin.groups.store') }}" class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf
    @include('admin.groups._form')
  </form>
@endsection
