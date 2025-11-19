@extends('admin.layout')
@section('title','تفاصيل الضيف')
@section('page_title','تفاصيل الضيف')

@section('content')
  <div class="bg-white border border-slate-200 rounded-2xl p-5 space-y-4">

    {{-- Header: name + flag dot + blacklist badge --}}
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2 text-xl font-extrabold">
        <span>{{ $guest->name }}</span>

    {{-- Blacklist warning (shown only if blacklisted) --}}
   

    {{-- Details --}}
    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <div class="text-xs text-slate-500 mb-1">المجموعة</div>
        @if($guest->group)
          <x-group.badge :name="$guest->group->name" :color="$guest->group->color" />
        @else
          <span class="text-slate-400 text-xs">—</span>
        @endif
      </div>

      <div>
        <div class="text-xs text-slate-500 mb-1">الجنسية</div>
        <div>{{ $guest->nationality ?: '—' }}</div>
      </div>

      <div>
        <div class="text-xs text-slate-500 mb-1">نوع/رقم الوثيقة</div>
        <div>
          @if($guest->document_type)
            {{ $guest->document_type === 'id' ? 'هوية' : 'جواز' }} — {{ $guest->document_number }}
          @else
            —
          @endif
        </div>
      </div>
    </div>

    {{-- Actions --}}
    <div class="pt-4 border-t flex items-center gap-2">
      <a href="{{ route('admin.guests.edit',$guest) }}"
         class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 hover:bg-amber-200 text-sm">تعديل</a>
      <a href="{{ route('admin.guests.index') }}"
         class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-sm">رجوع</a>
    </div>

  </div>
@endsection
