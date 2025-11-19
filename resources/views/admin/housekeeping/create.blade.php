{{-- create: resources/views/admin/housekeeping/create.blade.php --}}
@extends('admin.layout')
@section('title','مهمة تنظيف جديدة')
@section('page_title','إضافة مهمة تنظيف')
@section('content')
<form method="POST" action="{{ route('admin.housekeeping.store') }}" class="bg-white rounded-2xl border p-5">@csrf
  @include('admin.housekeeping._form')
</form>
@endsection
