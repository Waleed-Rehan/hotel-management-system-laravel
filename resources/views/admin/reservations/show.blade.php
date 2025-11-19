@extends('admin.layout')

@section('title','تفاصيل الحجز')
@section('page_title','تفاصيل الحجز')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  <div class="mb-4">
    <a href="{{ route('admin.reservations.index') }}" class="text-sm text-slate-600 hover:underline">← الرجوع للحجوزات</a>
  </div>

  @php
    // Nights count (guards against nulls)
    $nights = ($reservation->start_date && $reservation->end_date)
      ? $reservation->start_date->diffInDays($reservation->end_date)
      : null;
  @endphp

  <div class="grid lg:grid-cols-2 gap-6">
    {{-- Booking details --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
      <div class="flex items-center justify-between mb-4">
        <h2 class="font-extrabold text-lg">بيانات الحجز</h2>
        <span class="text-xs text-slate-400">#{{ $reservation->id }}</span>
      </div>

      <dl class="space-y-3 text-sm">
        <div class="flex items-center justify-between">
          <dt class="text-slate-500">الغرفة</dt>
          <dd class="font-medium">
            {{ $reservation->room?->number ? 'رقم '.$reservation->room->number : '—' }}
          </dd>
        </div>

        <div class="flex items-center justify-between">
          <dt class="text-slate-500">الفترة</dt>
          <dd class="font-medium">
            @if($reservation->start_date && $reservation->end_date)
              {{ $reservation->start_date->format('Y-m-d') }} → {{ $reservation->end_date->format('Y-m-d') }}
              @if(!is_null($nights))
                <span class="ml-2 text-slate-500 text-xs">({{ $nights }} ليلة)</span>
              @endif
            @else
              —
            @endif
          </dd>
        </div>

        <div class="flex items-center justify-between">
          <dt class="text-slate-500">الحالة</dt>
          <dd>
            <x-reservation.status-badge :status="$reservation->status" />
          </dd>
        </div>

        <div class="flex items-center justify-between">
          <dt class="text-slate-500">المدفوع</dt>
          <dd class="font-medium">{{ number_format($reservation->paid_amount ?? 0, 2) }}</dd>
        </div>

        <div class="flex items-center justify-between">
          <dt class="text-slate-500">أُنشئ بواسطة</dt>
          <dd class="font-medium">{{ $reservation->creator?->name ?? '—' }}</dd>
        </div>

        <div class="flex items-center justify-between">
          <dt class="text-slate-500">تاريخ الإنشاء</dt>
          <dd class="text-slate-600">
            {{ optional($reservation->created_at)->format('Y-m-d H:i') ?? '—' }}
          </dd>
        </div>
      </dl>

      <div class="mt-5 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.reservations.edit',$reservation) }}"
           class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 hover:bg-amber-200 text-sm">تعديل</a>

        <form method="POST" action="{{ route('admin.reservations.destroy',$reservation) }}"
              onsubmit="return confirm('حذف الحجز؟');">
          @csrf @method('DELETE')
          <button class="px-4 py-2 rounded-xl bg-rose-100 text-rose-800 hover:bg-rose-200 text-sm">حذف</button>
        </form>
      </div>
    </div>

    {{-- Guests --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5">
      <h2 class="font-extrabold text-lg mb-3">الضيوف</h2>

      @if($reservation->guests->count())
        <ul class="divide-y">
          @foreach($reservation->guests as $g)
            <li class="py-3">
              <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                  <div class="flex items-center gap-2">
                    {{-- Blacklist dot next to name --}}
                    <x-guest.flag-dot :blacklisted="($g->blacklist_strikes ?? 0) > 0" />
                    <a href="{{ route('admin.guests.show',$g) }}"
                       class="font-medium text-teal-700 hover:underline truncate">{{ $g->name }}</a>
                    @if(($g->blacklist_strikes ?? 0) > 0)
                      <span class="text-xs text-rose-600">(محظور: {{ $g->blacklist_strikes }})</span>
                    @endif
                  </div>

                  <div class="mt-1 text-xs text-slate-500 flex flex-wrap items-center gap-2">
                    {{-- Document --}}
                    <span>
                      @if($g->document_type)
                        {{ $g->document_type === 'id' ? 'هوية' : 'جواز' }}
                        @if($g->document_number) — {{ $g->document_number }} @endif
                      @else
                        وثيقة: —
                      @endif
                    </span>

                    {{-- Nationality --}}
                    <span class="text-slate-400">•</span>
                    <span>الجنسية: {{ $g->nationality ?: '—' }}</span>

                    {{-- Group badge (if any) --}}
                    @if($g->group)
                      <span class="text-slate-400">•</span>
                      <x-group.badge :name="$g->group->name" :color="$g->group->color" />
                    @endif
                  </div>
                </div>

                {{-- Quick actions per guest (optional hooks) --}}
                <div class="shrink-0 flex items-center gap-2">
                  <a href="{{ route('admin.guests.edit',$g) }}"
                     class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs">تعديل</a>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="text-slate-500 text-sm">لا يوجد ضيوف مرفقون.</div>
      @endif
    </div>
  </div>
@endsection
