@extends('admin.layout')

@section('title','الحجوزات')
@section('page_title','الحجوزات')
@section('page_subtitle','إدارة الحجوزات وإنشاء حجز جديد')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  {{-- Toolbar --}}
  <div class="mb-4 flex flex-col sm:flex-row gap-3 justify-between">
    <form method="GET" class="flex flex-wrap items-center gap-2">
      <input
        type="text"
        name="q"
        value="{{ $filters['q'] ?? '' }}"
        placeholder="ابحث عن غرفة أو ضيف…"
        class="rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200"
      >
      <select name="status" class="rounded-xl border border-slate-200 px-3 py-2">
        <option value="">كل الحالات</option>
        @foreach([
          'new'         => 'جديد',
          'confirmed'   => 'مؤكد',
          'checked_in'  => 'تم الدخول',
          'checked_out' => 'تم المغادرة',
          'canceled'    => 'ملغي'
        ] as $k => $v)
          <option value="{{ $k }}" @selected(($filters['status'] ?? '') === $k)>{{ $v }}</option>
        @endforeach
      </select>

      <button class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">تطبيق</button>

      @if(($filters['q'] ?? null) || ($filters['status'] ?? null))
        <a href="{{ route('admin.reservations.index') }}" class="text-sm text-slate-500 hover:underline">مسح</a>
      @endif>
    </form>

    <a href="{{ route('admin.reservations.create') }}"
       class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">حجز جديد</a>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
    <table class="w-full text-sm">
      <thead class="bg-slate-50">
        <tr class="text-right">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">الغرفة</th>
          <th class="px-4 py-3">الفترة</th>
          <th class="px-4 py-3">الضيوف</th>
          <th class="px-4 py-3">الحالة</th>
          <th class="px-4 py-3">المدفوع</th>
          <th class="px-4 py-3 w-40">العمليات</th>
        </tr>
      </thead>
      <tbody>
      @forelse($reservations as $r)
        @php
          // Will show a red flag if ANY guest in the reservation is blacklisted.
          $hasBlacklistedGuest = $r->guests->contains(fn($g) => ($g->blacklist_strikes ?? 0) > 0);
        @endphp
        <tr class="border-t">
          <td class="px-4 py-3">{{ $r->id }}</td>

          <td class="px-4 py-3">
            رقم {{ $r->room?->number }}
          </td>

          <td class="px-4 py-3 whitespace-nowrap">
            {{ $r->start_date->format('Y-m-d') }} → {{ $r->end_date->format('Y-m-d') }}
          </td>

          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              {{-- Flag dot if any guest is blacklisted --}}
              <x-guest.flag-dot :blacklisted="$hasBlacklistedGuest" />
              <div class="truncate max-w-[220px]" title="{{ $r->guests->pluck('name')->join('، ') }}">
                {{ $r->guests->pluck('name')->join('، ') }}
              </div>
            </div>
          </td>

          <td class="px-4 py-3">
            <x-reservation.status-badge :status="$r->status" />
          </td>

          <td class="px-4 py-3">
            {{ number_format($r->paid_amount, 2) }}
          </td>

          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <a href="{{ route('admin.reservations.show', $r) }}"
                 class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs">عرض</a>

              <a href="{{ route('admin.reservations.edit', $r) }}"
                 class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs">تعديل</a>

              <form method="POST"
                    action="{{ route('admin.reservations.destroy', $r) }}"
                    onsubmit="return confirm('حذف الحجز؟');">
                @csrf
                @method('DELETE')
                <button class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs">حذف</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="px-4 py-6 text-center text-slate-500">لا توجد حجوزات.</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $reservations->withQueryString()->links() }}</div>
@endsection
