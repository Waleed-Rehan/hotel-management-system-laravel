@props(['room'=>null, 'types'=>[], 'statuses'=>[]])

@php
  $r = $room;
@endphp

<div class="grid md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">رقم الغرفة</label>
    <input type="text" name="number" value="{{ old('number', $r->number ?? '') }}" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2">
  </div>

  <div>
    <label class="block text-sm mb-1">الدور</label>
    <input type="number" name="floor" value="{{ old('floor', $r->floor ?? 1) }}" min="0" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2">
  </div>

  <div>
    <label class="block text-sm mb-1">نوع الغرفة</label>
    <select name="room_type_id" required class="w-full rounded-xl border border-slate-200 px-3 py-2">
      <option value="">— اختر —</option>
      @foreach($types as $t)
        <option value="{{ $t->id }}" @selected(old('room_type_id', $r->room_type_id ?? null) == $t->id)>{{ $t->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label class="block text-sm mb-1">الحالة</label>
    <select name="status" required class="w-full rounded-xl border border-slate-200 px-3 py-2">
      @foreach($statuses as $st)
        <option value="{{ $st }}" @selected(old('status', $r->status ?? 'vacant')==$st)>
          {{ __([
            'vacant'=>'شاغرة','occupied'=>'مشغولة','cleaning'=>'تنظيف',
            'maintenance'=>'صيانة','out_of_service'=>'خارج الخدمة'
          ][$st]) }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm mb-1">السعر (اختياري)</label>
    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $r->price ?? '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2">
  </div>
</div>
