@php
  $isEdit = isset($reservation);
  $statuses = [
    'new' => 'جديد', 'confirmed' => 'مؤكد', 'checked_in' => 'تم الدخول',
    'checked_out' => 'تم المغادرة', 'canceled' => 'ملغي'
  ];

  // Selected guest ids for edit/validation back-fill
  $selected = collect(old('guest_ids', $isEdit ? $reservation->guests->pluck('id')->all() : []));
@endphp

<div class="grid sm:grid-cols-2 gap-4">
  {{-- Room --}}
  <div>
    <label class="block text-sm mb-1">الغرفة</label>
    <select name="room_id" class="w-full rounded-xl border border-slate-200 px-3 py-2">
      @foreach($rooms as $room)
        <option value="{{ $room->id }}"
                @selected(old('room_id', $reservation->room_id ?? '') == $room->id)>
          رقم {{ $room->number }}
        </option>
      @endforeach
    </select>
    @error('room_id') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Status --}}
  <div>
    <label class="block text-sm mb-1">الحالة</label>
    <select name="status" class="w-full rounded-xl border border-slate-200 px-3 py-2">
      @foreach($statuses as $k=>$v)
        <option value="{{ $k }}" @selected(old('status', $reservation->status ?? 'new') == $k)>{{ $v }}</option>
      @endforeach
    </select>
    @error('status') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Dates --}}
  <div>
    <label class="block text-sm mb-1">تاريخ البدء</label>
    <input type="date" name="start_date"
           value="{{ old('start_date', $isEdit ? $reservation->start_date->format('Y-m-d') : '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2">
    @error('start_date') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm mb-1">تاريخ الانتهاء</label>
    <input type="date" name="end_date"
           value="{{ old('end_date', $isEdit ? $reservation->end_date->format('Y-m-d') : '') }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2">
    @error('end_date') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Paid --}}
  <div>
    <label class="block text-sm mb-1">المبلغ المدفوع</label>
    <input type="number" step="0.01" name="paid_amount" min="0"
           value="{{ old('paid_amount', $reservation->paid_amount ?? 0) }}"
           class="w-full rounded-xl border border-slate-200 px-3 py-2">
    @error('paid_amount') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Guests select + quick add (no blacklist logic) --}}
  <div x-data="reservationGuests()" x-init="init()">
    <div class="flex items-center justify-between">
      <label class="block text-sm mb-1">الضيوف (اختر واحدًا أو أكثر)</label>
      <button type="button"
              @click="openQuick = !openQuick"
              class="text-xs px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200">
        + إضافة ضيف جديد
      </button>
    </div>

    <select x-ref="guestSelect"
            name="guest_ids[]"
            multiple size="6"
            class="w-full rounded-xl border border-slate-200 px-3 py-2">
      @foreach($guests as $g)
        <option value="{{ $g->id }}" @selected($selected->contains($g->id))>
          {{ $g->name }}
        </option>
      @endforeach
    </select>
    <div class="text-xs text-slate-500 mt-1">
      استخدم Ctrl/Cmd للاختيار المتعدد.
    </div>
    @error('guest_ids') <div class="text-rose-600 text-xs mt-1">{{ $message }}</div> @enderror

    {{-- Quick add panel --}}
    <div x-show="openQuick" x-cloak class="mt-3 rounded-xl border border-slate-200 p-3 space-y-2">
      <div class="text-sm font-bold">إضافة ضيف سريع</div>
      <div class="grid sm:grid-cols-2 gap-2">
        <div>
          <label class="block text-xs mb-1">الاسم *</label>
          <input type="text" x-model="quick.name"
                 class="w-full rounded-lg border border-slate-200 px-3 py-2" placeholder="اسم الضيف">
        </div>
        <div>
          <label class="block text-xs mb-1">الجنسية</label>
          <input type="text" x-model="quick.nationality"
                 class="w-full rounded-lg border border-slate-200 px-3 py-2" placeholder="الجنسية">
        </div>
        <div>
          <label class="block text-xs mb-1">نوع الوثيقة</label>
          <select x-model="quick.document_type"
                  class="w-full rounded-lg border border-slate-200 px-3 py-2">
            <option value="">—</option>
            <option value="id">هوية</option>
            <option value="passport">جواز سفر</option>
          </select>
        </div>
        <div>
          <label class="block text-xs mb-1">رقم الوثيقة</label>
          <input type="text" x-model="quick.document_number"
                 class="w-full rounded-lg border border-slate-200 px-3 py-2" placeholder="رقم الوثيقة">
        </div>
      </div>

      <div class="flex items-center gap-2">
        <button type="button"
                @click="saveGuest()"
                :disabled="saving || !quick.name"
                class="px-3 py-1.5 rounded-lg bg-teal-600 text-white text-sm hover:brightness-110 disabled:opacity-60">
          <span x-show="!saving">حفظ وإضافة للاختيار</span>
          <span x-show="saving">جار الحفظ…</span>
        </button>
        <button type="button" @click="openQuick=false" class="px-3 py-1.5 rounded-lg bg-slate-100 text-sm">
          إغلاق
        </button>
        <div class="text-xs text-rose-700" x-text="errorMsg"></div>
      </div>
    </div>
  </div>
</div>

{{-- Actions --}}
<div class="mt-6 flex items-center gap-3">
  <button class="px-5 py-2.5 rounded-xl bg-teal-600 text-white hover:brightness-110">
    {{ $isEdit ? 'حفظ التغييرات' : 'إنشاء الحجز' }}
  </button>
  <a href="{{ route('admin.reservations.index') }}"
     class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">إلغاء</a>
</div>

{{-- Quick-add logic only (no blacklist checks) --}}
@push('scripts')
<script>
function reservationGuests() {
  return {
    openQuick: false,
    saving: false,
    errorMsg: '',
    quick: { name: '', nationality: '', document_type: '', document_number: '' },

    init() {
      // No blacklist checks anymore
    },

    async saveGuest() {
      this.saving = true;
      this.errorMsg = '';
      try {
        // Ensure CSRF meta exists in your layout: <meta name="csrf-token" content="{{ csrf_token() }}">
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const res = await fetch("{{ route('admin.guests.quick-store') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.quick)
        });

        if (!res.ok) {
          const data = await res.json().catch(() => ({}));
          this.errorMsg = data?.message || 'تعذر إضافة الضيف. تحقق من البيانات.';
          this.saving = false;
          return;
        }

        const guest = await res.json(); // expects {id, name}
        // Append option and select it
        const opt = new Option(guest.name, guest.id, true, true);
        this.$refs.guestSelect.add(opt);

        // Reset
        this.quick = { name: '', nationality: '', document_type: '', document_number: '' };
        this.openQuick = false;
      } catch (err) {
        this.errorMsg = 'حدث خطأ غير متوقع.';
      } finally {
        this.saving = false;
      }
    }
  }
}
</script>
@endpush
