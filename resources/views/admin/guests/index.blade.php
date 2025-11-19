@extends('admin.layout')

@section('title','الضيوف')
@section('page_title','الضيوف')
@section('page_subtitle','إدارة بيانات الضيوف والمجموعات')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  {{-- Toolbar --}}
  <div class="mb-4 flex items-center justify-between gap-3">
    <form method="GET" class="flex flex-wrap items-center gap-2">
      <input
        type="text"
        name="q"
        value="{{ $q ?? '' }}"
        placeholder="ابحث بالاسم / الوثيقة / الجنسية"
        class="rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200"
      >

      <select
        name="group_id"
        class="rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200"
      >
        <option value="">كل المجموعات</option>
        @foreach($groups as $g)
          <option value="{{ $g->id }}" @selected(($group_id ?? '') == $g->id)>{{ $g->name }}</option>
        @endforeach
      </select>

      <button class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">
        تصفية
      </button>
    </form>

    <a
      href="{{ route('admin.guests.create') }}"
      class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110"
    >
      ضيف جديد
    </a>
  </div>

  {{-- Results meta --}}
  <div class="mb-2 text-xs text-slate-500">
    إجمالي: <span class="font-bold">{{ $guests->total() }}</span> ضيف/ضيوف
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
    <table class="w-full text-sm">
      <thead class="bg-slate-50">
        <tr class="text-right">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">الاسم</th>
          <th class="px-4 py-3">المجموعة</th>
          <th class="px-4 py-3">الوثيقة</th>
          <th class="px-4 py-3">الجنسية</th>
          <th class="px-4 py-3">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($guests as $guest)
          <tr class="border-t">
            <td class="px-4 py-3 whitespace-nowrap">{{ $guest->id }}</td>

            {{-- NAME --}}
            <td class="px-4 py-3">
              <a
                href="{{ route('admin.guests.show', $guest) }}"
                class="text-teal-700 hover:underline"
              >
                {{ $guest->name }}
              </a>
            </td>

            {{-- GROUP --}}
            <td class="px-4 py-3">
              @if($guest->group)
                <x-group.badge :name="$guest->group->name" :color="$guest->group->color" />
              @else
                <span class="text-slate-400 text-xs">—</span>
              @endif
            </td>

            {{-- DOCUMENT --}}
            <td class="px-4 py-3 whitespace-nowrap" dir="ltr">
              @if($guest->document_type)
                <span dir="rtl">
                  {{ $guest->document_type === 'id' ? 'هوية' : 'جواز' }} —
                </span>
                {{ $guest->document_number }}
              @else
                <span class="text-slate-400 text-xs">—</span>
              @endif
            </td>

            {{-- NATIONALITY --}}
            <td class="px-4 py-3 whitespace-nowrap">{{ $guest->nationality ?: '—' }}</td>

            {{-- ACTIONS --}}
            <td class="px-4 py-3">
              <div class="flex items-center gap-2">
                <a
                  href="{{ route('admin.guests.edit', $guest) }}"
                  class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs"
                >
                  تعديل
                </a>

                <form
                  method="POST"
                  action="{{ route('admin.guests.destroy', $guest) }}"
                  onsubmit="return confirm('حذف الضيف؟');"
                >
                  @csrf @method('DELETE')
                  <button
                    class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs"
                  >
                    حذف
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-4 py-6 text-center text-slate-500">
              لا توجد سجلات.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $guests->withQueryString()->links() }}
  </div>
@endsection
