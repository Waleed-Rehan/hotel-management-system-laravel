@extends('admin.layout')

@section('title', 'تفاصيل المجموعة')
@section('page_title', 'تفاصيل المجموعة')
@section('page_subtitle', $group->name)

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  <div class="mb-4 flex items-center gap-2">
    <a href="{{ route('admin.groups.index') }}" class="text-sm text-slate-600 hover:underline">← رجوع للمجموعات</a>
  </div>

  <div class="grid lg:grid-cols-2 gap-6">
    {{-- Group card --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
      <h2 class="font-extrabold text-lg mb-3">المجموعة</h2>

      <div class="space-y-3 text-sm">
        <div class="flex items-center justify-between">
          <span class="text-slate-500">الاسم</span>
          <span class="font-bold">{{ $group->name }}</span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-slate-500">اللون</span>
          <span class="inline-flex items-center gap-2">
            <span class="inline-block w-4 h-4 rounded" style="background: {{ $group->color ?? '#e2e8f0' }}"></span>
            <span class="text-slate-700">{{ $group->color ?: '—' }}</span>
          </span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-slate-500">تاريخ الإنشاء</span>
          <span>{{ $group->created_at?->format('Y-m-d H:i') }}</span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-slate-500">آخر تحديث</span>
          <span>{{ $group->updated_at?->format('Y-m-d H:i') }}</span>
        </div>
      </div>

      <div class="mt-5 flex items-center gap-2">
        <a href="{{ route('admin.groups.edit',$group) }}"
           class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 hover:bg-amber-200 text-sm">تعديل</a>
        <form method="POST" action="{{ route('admin.groups.destroy',$group) }}"
              onsubmit="return confirm('حذف المجموعة؟');">
          @csrf @method('DELETE')
          <button class="px-4 py-2 rounded-xl bg-rose-100 text-rose-800 hover:bg-rose-200 text-sm">حذف</button>
        </form>
      </div>
    </div>

    {{-- (Optional) Members/Guests list if relation exists --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
      <h2 class="font-extrabold text-lg mb-3">الضيوف في المجموعة</h2>

      @php
        // If you eager-load with ->loadCount('guests') and ->load('guests') this section will show data.
        $guests = $group->guests ?? collect();
      @endphp

      @if($guests->count())
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-slate-50">
              <tr class="text-right">
                <th class="px-3 py-2">#</th>
                <th class="px-3 py-2">الاسم</th>
                <th class="px-3 py-2">الجنسية</th>
                <th class="px-3 py-2">الوثيقة</th>
              </tr>
            </thead>
            <tbody>
              @foreach($guests as $g)
                <tr class="border-t">
                  <td class="px-3 py-2">{{ $g->id }}</td>
                  <td class="px-3 py-2">{{ $g->name }}</td>
                  <td class="px-3 py-2">{{ $g->nationality ?: '—' }}</td>
                  <td class="px-3 py-2">
                    @if($g->document_type)
                      {{ $g->document_type === 'id' ? 'هوية' : 'جواز سفر' }} — {{ $g->document_number ?: '—' }}
                    @else
                      —
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-slate-500 text-sm">لا يوجد ضيوف في هذه المجموعة.</div>
      @endif
    </div>
  </div>
@endsection
