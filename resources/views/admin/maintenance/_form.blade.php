@php
  $isEdit = isset($ticket);
  $statuses = ['open'=>'مفتوح','in_progress'=>'قيد التنفيذ','on_hold'=>'معلّق','closed'=>'مغلق'];
@endphp

<div class="grid sm:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">الغرفة</label>
    <select name="room_id" required class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
      @foreach($rooms as $r)
        <option value="{{ $r->id }}" @selected(old('room_id', $ticket->room_id ?? '')==$r->id)>#{{ $r->number }}</option>
      @endforeach
    </select>
    @error('room_id') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">الحالة</label>
    <select name="status" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
      @foreach($statuses as $key => $label)
        <option value="{{ $key }}" @selected(old('status', $ticket->status ?? 'open')==$key)>{{ $label }}</option>
      @endforeach
    </select>
    @error('status') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="sm:col-span-2">
    <label class="block text-sm mb-1">وصف المشكلة</label>
    <textarea name="issue" rows="4" required
              class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">{{ old('issue', $ticket->issue ?? '') }}</textarea>
    @error('issue') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="sm:col-span-2">
    <label class="block text-sm mb-1">الأدوات المطلوبة (اختياري)</label>
    <textarea name="tools_request" rows="3"
              class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">{{ old('tools_request', $ticket->tools_request ?? '') }}</textarea>
    @error('tools_request') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button class="px-5 py-2.5 rounded-xl bg-teal-600 text-white hover:brightness-110">
    {{ $isEdit ? 'حفظ' : 'فتح البلاغ' }}
  </button>
  <a href="{{ route('admin.maintenance.index') }}" class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">إلغاء</a>
</div>
