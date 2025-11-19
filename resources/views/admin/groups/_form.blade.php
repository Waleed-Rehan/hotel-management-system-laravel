@php $isEdit = isset($group); @endphp

<div class="grid sm:grid-cols-2 gap-4">
  <div class="sm:col-span-2">
    <label class="block text-sm mb-1">اسم المجموعة</label>
    <input type="text" name="name" required
           value="{{ old('name', $group->name ?? '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200"
           placeholder="مثال: عملاء الشركات">
    @error('name') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="sm:col-span-2">
    <label class="block text-sm mb-1">اللون (اختياري)</label>
    <input type="text" name="color"
           value="{{ old('color', $group->color ?? '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:ring-2 focus:ring-teal-200"
           placeholder="#10b981 أو teal">
    @error('color') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button class="px-5 py-2.5 rounded-xl bg-teal-600 text-white hover:brightness-110">
    {{ $isEdit ? 'حفظ' : 'إضافة' }}
  </button>
  <a href="{{ route('admin.groups.index') }}"
     class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">إلغاء</a>
</div>
