@php $isEdit = isset($guest); @endphp

<div class="grid sm:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">الاسم</label>
    <input type="text" name="name" value="{{ old('name', $guest->name ?? '') }}" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
    @error('name') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">الجنسية</label>
    <input type="text" name="nationality" value="{{ old('nationality', $guest->nationality ?? '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
    @error('nationality') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">نوع الوثيقة</label>
    <select name="document_type" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
      <option value="">—</option>
      <option value="id"       @selected(old('document_type', $guest->document_type ?? '')==='id')>هوية</option>
      <option value="passport" @selected(old('document_type', $guest->document_type ?? '')==='passport')>جواز سفر</option>
    </select>
    @error('document_type') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">رقم الوثيقة</label>
    <input type="text" name="document_number" value="{{ old('document_number', $guest->document_number ?? '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
    @error('document_number') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">الضربات السوداء (0-∞)</label>
    <input type="number" name="blacklist_strikes" min="0" value="{{ old('blacklist_strikes', $guest->blacklist_strikes ?? 0) }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
    @error('blacklist_strikes') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">المجموعة</label>
    <select name="group_id" class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200">
      <option value="">— بدون —</option>
      @foreach($groups as $g)
        <option value="{{ $g->id }}" @selected(old('group_id', $guest->group_id ?? null)===$g->id)>{{ $g->name }}</option>
      @endforeach
    </select>
    @error('group_id') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button class="px-5 py-2.5 rounded-xl bg-teal-600 text-white hover:brightness-110">
    {{ $isEdit ? 'حفظ' : 'إضافة' }}
  </button>
  <a href="{{ route('admin.guests.index') }}" class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">إلغاء</a>
</div>
