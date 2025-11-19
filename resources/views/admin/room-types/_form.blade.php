@php
  $isEdit = isset($type);
@endphp

<div class="grid sm:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">الاسم</label>
    <input type="text" name="name" value="{{ old('name', $type->name ?? '') }}" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200">
    @error('name') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">السعة (نزلاء)</label>
    <input type="number" name="capacity" min="1" value="{{ old('capacity', $type->capacity ?? 1) }}" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200">
    @error('capacity') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">عدد الأسرة</label>
    <input type="number" name="beds" min="1" value="{{ old('beds', $type->beds ?? 1) }}" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200">
    @error('beds') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">السعر الأساسي</label>
    <input type="number" step="0.01" min="0" name="base_price"
           value="{{ old('base_price', $type->base_price ?? 0) }}" required
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200">
    @error('base_price') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button type="submit"
          class="px-5 py-2.5 rounded-xl bg-teal-600 text-white hover:brightness-110">
    {{ $isEdit ? 'حفظ التغييرات' : 'إنشاء' }}
  </button>
  <a href="{{ route('admin.room-types.index') }}"
     class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">
    إلغاء
  </a>
</div>
