{{-- edit: resources/views/admin/housekeeping/edit.blade.php --}}
@extends('admin.layout')
@section('title','تعديل مهمة تنظيف')
@section('page_title','تعديل مهمة تنظيف')
@section('content')
<form method="POST" action="{{ route('admin.housekeeping.update',$task) }}" class="bg-white rounded-2xl border p-5">
  @csrf @method('PUT')
  @include('admin.housekeeping._form', ['task'=>$task])
</form>
@endsection
