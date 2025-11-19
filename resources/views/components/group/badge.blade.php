@props(['name' => null, 'color' => null])

@php
  // map simple color names to classes (fallback to slate)
  $colors = [
    'teal'   => ['bg'=>'bg-teal-50','text'=>'text-teal-700','ring'=>'ring-teal-200/60'],
    'amber'  => ['bg'=>'bg-amber-50','text'=>'text-amber-700','ring'=>'ring-amber-200/60'],
    'sky'    => ['bg'=>'bg-sky-50','text'=>'text-sky-700','ring'=>'ring-sky-200/60'],
    'rose'   => ['bg'=>'bg-rose-50','text'=>'text-rose-700','ring'=>'ring-rose-200/60'],
    'slate'  => ['bg'=>'bg-slate-100','text'=>'text-slate-700','ring'=>'ring-slate-200/60'],
  ];
  $c = $colors[$color] ?? $colors['slate'];
@endphp

<span {{ $attributes->merge([
  'class' => "inline-flex items-center px-2.5 py-1 rounded-lg text-xs {$c['bg']} {$c['text']} ring-1 {$c['ring']}"
]) }}>
  {{ $name ?? 'بدون مجموعة' }}
</span>
