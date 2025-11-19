@extends('admin.layout')

@section('title','تعديل حجز')
@section('page_title','تعديل حجز')

@section('content')

  {{-- Flash success (in case you redirect back here after an update elsewhere) --}}
  @if(session('success'))
    <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  {{-- Validation errors --}}
  @if ($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 text-rose-800 px-4 py-3 text-sm">
      <div class="font-bold mb-1">تعذّر حفظ التعديلات:</div>
      <ul class="list-disc pr-5 space-y-0.5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="mb-4">
    <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-sm text-slate-600 hover:underline">
      ← الرجوع للتفاصيل
    </a>
  </div>

  <form method="POST"
        action="{{ route('admin.reservations.update', $reservation) }}"
        class="bg-white border border-slate-200 rounded-2xl p-5 space-y-4">
    @csrf
    @method('PUT')

    {{-- 
      The partial should render all inputs.
      We pass:
        - $reservation
        - $rooms      (from controller edit() -> with ['rooms'=>..., 'guests'=>...])
        - $guests
        - $isEdit     (so the partial can change button labels / defaults)
    --}}
    @include('admin.reservations._form', [
      'reservation' => $reservation,
      'rooms'       => $rooms ?? null,
      'guests'      => $guests ?? null,
      'isEdit'      => true,
    ])

    {{-- In case the partial does not include action buttons --}}
    <div class="flex items-center gap-3">
      <button type="submit"
              class="px-5 py-2.5 rounded-xl bg-teal-600 text-white hover:brightness-110">
        حفظ التعديلات
      </button>
      <a href="{{ route('admin.reservations.show', $reservation) }}"
         class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">
        إلغاء
      </a>
    </div>
  </form>
@endsection
