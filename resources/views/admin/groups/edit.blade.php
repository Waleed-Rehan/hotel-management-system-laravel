@extends('admin.layout')

@section('title','تعديل مجموعة')
@section('page_title','تعديل مجموعة')

@section('content')
  <form method="POST" action="{{ route('admin.groups.update', $group) }}" class="bg-white border border-slate-200 rounded-2xl p-5">
    @csrf @method('PUT')
    @include('admin.groups._form', ['group' => $group])
  </form>
@endsection
