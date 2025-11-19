@extends('admin.layout')

@section('title','تفاصيل نوع الغرفة')
@section('page_title','تفاصيل نوع الغرفة')

@section('content')
  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
      <div class="text-sm text-slate-500 mb-2">الاسم</div>
      <div class="text-lg font-extrabold">{{ $type->name }}</div>

      <div class="mt-4 grid grid-cols-3 gap-3">
        <div class="rounded-xl bg-teal-50 border border-teal-100 p-3 text-center">
          <div class="text-xs text-slate-500">السعة</div>
          <div class="font-bold">{{ $type->capacity }}</div>
        </div>
        <div class="rounded-xl bg-amber-50 border border-amber-100 p-3 text-center">
          <div class="text-xs text-slate-500">الأسرة</div>
          <div class="font-bold">{{ $type->beds }}</div>
        </div>
        <div class="rounded-xl bg-sky-50 border border-sky-100 p-3 text-center">
          <div class="text-xs text-slate-500">السعر الأساسي</div>
          <div class="font-bold" dir="ltr">{{ number_format($type->base_price, 2) }}</div>
        </div>
      </div>

      <div class="mt-4 text-sm text-slate-600">
        عدد الغرف من هذا النوع: <span class="font-bold">{{ $type->rooms_count }}</span>
      </div>

      <div class="mt-6 flex items-center gap-2">
        <a href="{{ route('admin.room-types.edit', $type) }}"
           class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 hover:bg-amber-200 text-sm">تعديل</a>

        <form method="POST" action="{{ route('admin.room-types.destroy', $type) }}"
              onsubmit="return confirm('حذف هذا النوع؟');">
          @csrf @method('DELETE')
          <button class="px-4 py-2 rounded-xl bg-rose-100 text-rose-800 hover:bg-rose-200 text-sm">حذف</button>
        </form>

        <a href="{{ route('admin.room-types.index') }}"
           class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-sm">رجوع</a>
      </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5">
      <div class="text-sm text-slate-500 mb-3">تلميحات</div>
      <ul class="list-disc pr-5 text-sm text-slate-600 space-y-2">
        <li>يمكنك ربط السعر الأساسي مع تسعير الغرف أو الأسعار الموسمية لاحقًا.</li>
        <li>تأكد من أن السعة وعدد الأسرة متناسقان مع سياسات الفندق.</li>
      </ul>
    </div>
  </div>
@endsection
