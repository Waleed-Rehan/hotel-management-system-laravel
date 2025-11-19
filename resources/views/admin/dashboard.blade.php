@extends('admin.layout')

@section('title','لوحة التحكم')
@section('page_title','لوحة التحكم')
@section('page_subtitle','نظرة عامة على أهم المؤشرات وروابط الوصول السريع')

@section('content')
  {{-- KPIs --}}
  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-admin.stat label="الغرف المتاحة" value="34" hint="من أصل 120" icon="🛏️" />
    <x-admin.stat label="النزلاء المقيمون" value="78" hint="اليوم" icon="👥" />
    <x-admin.stat label="حجوزات اليوم" value="26" hint="الوصول / المغادرة" icon="🧳" />
    <x-admin.stat label="إيراد اليوم" value="SAR 12,450" hint="غير شامل الضرائب" icon="💳" />
  </div>

  {{-- Quick links --}}
  <h3 class="mt-8 mb-3 text-lg font-extrabold">وصول سريع</h3>
  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <x-admin.tile icon="🛏️" title="الغرف" desc="إدارة الغرف وحالاتها"
      :href="route('admin.rooms.index')" />
    <x-admin.tile icon="🏷️" title="أنواع الغرف" desc="تعريف وتسعير الأنواع"
      :href="route('admin.room-types.index')" />
    <x-admin.tile icon="🧳" title="الحجوزات" desc="إنشاء وتعديل ومتابعة"
      :href="route('admin.reservations.index')" />
    <x-admin.tile icon="👤" title="الضيوف" desc="ملفات الضيوف وسجل الإقامة"
      :href="route('admin.guests.index')" />
    <x-admin.tile icon="🧼" title="التنظيف" desc="مهام التدبير الفندقي"
      :href="route('admin.housekeeping.index')" />
    <x-admin.tile icon="🛠️" title="الصيانة" desc="بلاغات وأوامر العمل"
      :href="route('admin.maintenance.index')" />
    <x-admin.tile icon="💳" title="المالية" desc="حركات الصندوق والمعاملات"
      :href="route('admin.finance.index')" />
    <x-admin.tile icon="👥" title="المجموعات" desc="حجوزات المجموعات"
      :href="route('admin.groups.index')" />
    <x-admin.tile icon="📊" title="التقارير" desc="أرباح وخسائر، سجل سنوي، صندوق"
      :href="route('admin.reports.index')" />
  </div>

  {{-- Recent activity (placeholder table) --}}
  <h3 class="mt-10 mb-3 text-lg font-extrabold">آخر الأنشطة</h3>
  <div class="overflow-x-auto rounded-2xl bg-white border border-slate-200">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-600">
        <tr>
          <th class="px-4 py-3 text-right">الوقت</th>
          <th class="px-4 py-3 text-right">النوع</th>
          <th class="px-4 py-3 text-right">الوصف</th>
          <th class="px-4 py-3 text-right">بواسطة</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        <tr>
          <td class="px-4 py-3">10:15</td>
          <td class="px-4 py-3">حجز</td>
          <td class="px-4 py-3">إنشاء حجز لغرفة 402 لمدة 3 ليالٍ</td>
          <td class="px-4 py-3">Ahmed S.</td>
        </tr>
        <tr>
          <td class="px-4 py-3">09:40</td>
          <td class="px-4 py-3">تنظيف</td>
          <td class="px-4 py-3">اكتمال تنظيف غرفة 205</td>
          <td class="px-4 py-3">Mona K.</td>
        </tr>
        <tr>
          <td class="px-4 py-3">09:10</td>
          <td class="px-4 py-3">مالية</td>
          <td class="px-4 py-3">تحصيل دفعة نقدية بقيمة SAR 540</td>
          <td class="px-4 py-3">System</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
