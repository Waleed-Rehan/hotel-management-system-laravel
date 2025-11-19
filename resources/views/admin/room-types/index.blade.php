@extends('admin.layout')

@section('title','أنواع الغرف')
@section('page_title','أنواع الغرف')
@section('page_subtitle','إدارة تصنيفات الغرف والسعات والتسعير')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  <div class="mb-4 flex items-center justify-between">
    <form method="GET" class="flex items-center gap-2">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث بالاسم"
             class="rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200">
      <button class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">بحث</button>
    </form>

    <a href="{{ route('admin.room-types.create') }}"
       class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">نوع جديد</a>
  </div>

  <div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
    <table class="w-full text-sm">
      <thead class="bg-slate-50">
        <tr class="text-right">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">الاسم</th>
          <th class="px-4 py-3">السعة</th>
          <th class="px-4 py-3">الأسرة</th>
          <th class="px-4 py-3">السعر الأساسي</th>
          <th class="px-4 py-3">عدد الغرف</th>
          <th class="px-4 py-3">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($types as $type)
          <tr class="border-t">
            <td class="px-4 py-3">{{ $type->id }}</td>
            <td class="px-4 py-3">
              <a href="{{ route('admin.room-types.show', $type) }}" class="text-teal-700 hover:underline">
                {{ $type->name }}
              </a>
            </td>
            <td class="px-4 py-3">{{ $type->capacity }}</td>
            <td class="px-4 py-3">{{ $type->beds }}</td>
            <td class="px-4 py-3"><span dir="ltr">{{ number_format($type->base_price, 2) }}</span></td>
            <td class="px-4 py-3">{{ $type->rooms_count }}</td>
            <td class="px-4 py-3">
              <div class="flex items-center gap-2">
                <a href="{{ route('admin.room-types.edit', $type) }}"
                   class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs">تعديل</a>
                <form method="POST" action="{{ route('admin.room-types.destroy', $type) }}"
                      onsubmit="return confirm('حذف هذا النوع؟');">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs">
                    حذف
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-4 py-6 text-center text-slate-500">لا توجد أنواع غرف بعد.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $types->withQueryString()->links() }}
  </div>
@endsection
