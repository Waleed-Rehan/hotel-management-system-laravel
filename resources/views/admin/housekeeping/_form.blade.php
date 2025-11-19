@php $isEdit = isset($task); @endphp
<div class="grid sm:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">الغرفة</label>
    <select name="room_id" required class="w-full rounded-xl border border-slate-200 px-3 py-2">
      @foreach($rooms as $r)
        <option value="{{ $r->id }}" @selected(old('room_id',$task->room_id ?? '')==$r->id)>#{{ $r->number }}</option>
      @endforeach
    </select>
    @error('room_id')<div class="text-rose-600 text-xs mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">يحتاج طعام؟</label>
    <select name="needs_food" class="w-full rounded-xl border border-slate-200 px-3 py-2">
      <option value="0" @selected(old('needs_food',$task->needs_food ?? 0)==0)>لا</option>
      <option value="1" @selected(old('needs_food',$task->needs_food ?? 0)==1)>نعم</option>
    </select>
    @error('needs_food')<div class="text-rose-600 text-xs mt-1">{{ $message }}</div>@enderror
  </div>
  <div class="sm:col-span-2">
    <label class="block text-sm mb-1">ملاحظات</label>
    <textarea name="notes" rows="4" class="w-full rounded-xl border border-slate-200 px-3 py-2">{{ old('notes',$task->notes ?? '') }}</textarea>
    @error('notes')<div class="text-rose-600 text-xs mt-1">{{ $message }}</div>@enderror
  </div>
</div>
<div class="mt-6 flex items-center gap-3">
  <button class="px-5 py-2.5 rounded-xl bg-teal-600 text-white">{{ $isEdit? 'حفظ' : 'إضافة' }}</button>
  <a href="{{ route('admin.housekeeping.index') }}" class="px-5 py-2.5 rounded-xl bg-white border border-slate-200">إلغاء</a>
</div>
