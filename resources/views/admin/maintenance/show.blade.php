@extends('admin.layout')
@section('title','عرض بلاغ صيانة')
@section('page_title','تفاصيل بلاغ الصيانة')

@section('content')
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-2xl border border-slate-200 p-5 text-sm">
    <div class="grid sm:grid-cols-2 gap-4">
      <div><b>الغرفة:</b> #{{ $ticket->room?->number }}</div>
      <div>
        <b>الحالة:</b>
        @php
          $map = [
            'open' => ['مفتوح','bg-amber-50 text-amber-700'],
            'in_progress' => ['قيد التنفيذ','bg-sky-50 text-sky-700'],
            'on_hold' => ['معلّق','bg-slate-100 text-slate-700'],
            'closed' => ['مغلق','bg-teal-50 text-teal-700'],
          ];
          [$label,$cls] = $map[$ticket->status] ?? [$ticket->status,'bg-slate-100 text-slate-700'];
        @endphp
        <span class="px-2 py-1 rounded-lg text-xs {{ $cls }}">{{ $label }}</span>
      </div>

      <div class="sm:col-span-2"><b>المشكلة:</b> {{ $ticket->issue }}</div>
      <div class="sm:col-span-2"><b>الأدوات المطلوبة:</b> {{ $ticket->tools_request ?: '—' }}</div>

      <div><b>المُنشئ:</b> {{ $ticket->creator?->name ?: '—' }}</div>
      <div><b>أُنشئ في:</b> {{ $ticket->created_at->format('Y-m-d H:i') }}</div>
      <div><b>أُغلق في:</b> {{ $ticket->completed_at ? $ticket->completed_at->format('Y-m-d H:i') : '—' }}</div>
    </div>

    <div class="mt-5 flex flex-wrap items-center gap-2">
      <a href="{{ route('admin.maintenance.edit',$ticket) }}" class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 hover:bg-amber-200">تعديل</a>

      @if($ticket->status !== 'closed')
        <form method="POST" action="{{ route('admin.maintenance.close',$ticket) }}">@csrf @method('PATCH')
          <button class="px-4 py-2 rounded-xl bg-teal-100 text-teal-800 hover:bg-teal-200">إغلاق</button>
        </form>
      @else
        <form method="POST" action="{{ route('admin.maintenance.reopen',$ticket) }}">@csrf @method('PATCH')
          <button class="px-4 py-2 rounded-xl bg-slate-100 text-slate-800 hover:bg-slate-200">إعادة فتح</button>
        </form>
      @endif

      <form method="POST" action="{{ route('admin.maintenance.destroy',$ticket) }}" onsubmit="return confirm('حذف البلاغ؟');">
        @csrf @method('DELETE')
        <button class="px-4 py-2 rounded-xl bg-rose-100 text-rose-800 hover:bg-rose-200">حذف</button>
      </form>

      <a href="{{ route('admin.maintenance.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">رجوع</a>
    </div>
  </div>
@endsection
