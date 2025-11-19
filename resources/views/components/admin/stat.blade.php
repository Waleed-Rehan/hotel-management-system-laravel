@props(['label' => 'المؤشر', 'value' => '-', 'hint' => null, 'icon' => '📈'])

<div class="rounded-2xl bg-white border border-slate-200 p-5">
  <div class="flex items-center justify-between">
    <div class="text-2xl">{{ $icon }}</div>
    <div class="text-xs px-2 py-1 rounded-lg bg-slate-100 text-slate-600">{{ $label }}</div>
  </div>
  <div class="mt-4 text-3xl font-extrabold">{{ $value }}</div>
  @if($hint)
    <div class="mt-1 text-sm text-slate-500">{{ $hint }}</div>
  @endif
</div>
