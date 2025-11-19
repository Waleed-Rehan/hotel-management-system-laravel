@props(['status'])

@php
  $map = [
    'new'         => ['bg'=>'bg-slate-100','text'=>'text-slate-700','label'=>'جديد'],
    'confirmed'   => ['bg'=>'bg-teal-50','text'=>'text-teal-700','label'=>'مؤكد'],
    'checked_in'  => ['bg'=>'bg-amber-50','text'=>'text-amber-700','label'=>'تم الدخول'],
    'checked_out' => ['bg'=>'bg-sky-50','text'=>'text-sky-700','label'=>'تم المغادرة'],
    'canceled'    => ['bg'=>'bg-rose-100','text'=>'text-rose-800','label'=>'ملغي'],
  ][$status] ?? ['bg'=>'bg-slate-100','text'=>'text-slate-700','label'=>$status];
@endphp

<span {{ $attributes->merge(['class'=>"inline-flex items-center px-2.5 py-1 rounded-lg text-xs {$map['bg']} {$map['text']}"]) }}>
  {{ $map['label'] }}
</span>
