{{-- views/landing.blade.php --}}
@extends('layouts.landing')

@section('title', 'الصفحة الرئيسية')

@section('content')
  <x-landing.card title="الغرف" href="{{ route('admin.rooms.index') }}">
    إدارة الغرف، الأنواع، الحالات.
  </x-landing.card>

  <x-landing.card title="الحجوزات" href="{{ route('admin.reservations.index') }}">
    إنشاء، تعديل، تسجيل الدخول والخروج.
  </x-landing.card>

  <x-landing.card title="الخدمات" href="{{ route('admin.housekeeping.index') }}">
    <span class="pill">التنظيف</span> <span class="pill">الصيانة</span>
  </x-landing.card>

  <x-landing.card title="التقارير" href="{{ route('admin.reports.profit_loss') }}">
    الربح والخسارة – كشف الحساب السنوي.
  </x-landing.card>
@endsection
