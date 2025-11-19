@extends('admin.layout')

@section('title', 'تفاصيل الغرفة')
@section('page_title', 'تفاصيل الغرفة')
@section('page_subtitle', 'عرض بيانات الغرفة والمعلومات المرتبطة')

@section('content')
  {{-- شريط تنقل بسيط --}}
  <nav class="text-sm text-slate-500 mb-4">
    <a href="{{ route('admin.dashboard') }}" class="hover:underline">لوحة التحكم</a>
    <span class="mx-2">/</span>
    <a href="{{ route('admin.rooms.index') }}" class="hover:underline">الغرف</a>
    <span class="mx-2">/</span>
    <span class="text-slate-700">الغرفة رقم {{ $room->number }}</span>
  </nav>

  <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
    {{-- بطاقة التفاصيل الرئيسية --}}
    <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
      <div class="flex items-start justify-between gap-4">
        <div>
          <h2 class="text-xl font-extrabold text-slate-900">
            الغرفة رقم {{ $room->number }}
          </h2>
          <p class="text-sm text-slate-500 mt-1">
            النوع: {{ $room->type->name ?? '—' }} · الدور: {{ $room->floor }}
          </p>
        </div>

        {{-- شارة الحالة --}}
        @php
          $status = $room->status;
          $badge = match($status){
            'vacant'          => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'occupied'        => 'bg-amber-50 text-amber-700 border-amber-100',
            'cleaning'        => 'bg-sky-50 text-sky-700 border-sky-100',
            'maintenance'     => 'bg-rose-50 text-rose-700 border-rose-100',
            'out_of_service'  => 'bg-gray-100 text-gray-700 border-gray-200',
            default           => 'bg-slate-100 text-slate-700 border-slate-200',
          };
        @endphp
        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs border {{ $badge }}">
          الحالة: {{ __($room->status) }}
        </span>
      </div>

      <div class="mt-6 grid sm:grid-cols-2 gap-4">
        <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/40">
          <div class="text-xs text-slate-500 mb-1">السعر</div>
          <div class="text-lg font-bold">
            {{ is_null($room->price) ? '—' : number_format($room->price, 2) }} <span class="text-sm font-normal">ر.س</span>
          </div>
        </div>

        <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/40">
          <div class="text-xs text-slate-500 mb-1">الدور</div>
          <div class="text-lg font-bold">{{ $room->floor }}</div>
        </div>
      </div>

      {{-- أكشنز --}}
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.rooms.edit', $room) }}"
           class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">
          تعديل
        </a>

        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
              onsubmit="return confirm('هل أنت متأكد من حذف الغرفة؟');">
          @csrf @method('DELETE')
          <button type="submit"
                  class="px-4 py-2 rounded-xl bg-rose-50 text-rose-700 border border-rose-100 hover:bg-rose-100">
            حذف
          </button>
        </form>

        <a href="{{ route('admin.rooms.index') }}"
           class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50">
          الرجوع لقائمة الغرف
        </a>
      </div>
    </section>

    {{-- لوحة موجزة جانبية (اختيارية) --}}
    <aside class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
      <h3 class="font-bold text-slate-900 mb-4">معلومات سريعة</h3>
      <ul class="space-y-3 text-sm">
        <li class="flex items-center justify-between">
          <span class="text-slate-500">الرقم</span>
          <span class="font-medium text-slate-800">{{ $room->number }}</span>
        </li>
        <li class="flex items-center justify-between">
          <span class="text-slate-500">النوع</span>
          <span class="font-medium text-slate-800">{{ $room->type->name ?? '—' }}</span>
        </li>
        <li class="flex items-center justify-between">
          <span class="text-slate-500">الحالة</span>
          <span class="font-medium text-slate-800">{{ __($room->status) }}</span>
        </li>
        <li class="flex items-center justify-between">
          <span class="text-slate-500">آخر تحديث</span>
          <span class="font-medium text-slate-800">{{ $room->updated_at->format('Y-m-d H:i') }}</span>
        </li>
      </ul>
    </aside>
  </div>
@endsection
