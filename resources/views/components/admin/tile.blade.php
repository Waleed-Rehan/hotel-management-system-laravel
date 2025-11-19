@props(['href' => '#', 'title' => '', 'desc' => '', 'icon' => '➡️'])

<a href="{{ $href }}" class="block group">
  <div class="rounded-2xl bg-white border border-slate-200 p-5 hover:shadow-md hover:-translate-y-1 transition">
    <div class="flex items-start gap-3">
      <div class="text-3xl leading-none">{{ $icon }}</div>
      <div>
        <div class="font-extrabold">{{ $title }}</div>
        @if($desc)
          <div class="text-sm text-slate-500 mt-1">{{ $desc }}</div>
        @endif
      </div>
    </div>
  </div>
</a>
