@props(['status'])

@php
  $map = [
    'vacant'         => ['bg' => 'bg-teal-50',       'text'=>'text-teal-700', 'label'=>'شاغرة'],
    'occupied'       => ['bg' => 'bg-slate-100',     'text'=>'text-slate-700','label'=>'مشغولة'],
    'cleaning'       => ['bg' => 'bg-amber-50',      'text'=>'text-amber-700','label'=>'تنظيف'],
    'maintenance'    => ['bg' => 'bg-rose-50',       'text'=>'text-rose-700', 'label'=>'صيانة'],
    'out_of_service' => ['bg' => 'bg-rose-100',      'text'=>'text-rose-800', 'label'=>'خارج الخدمة'],
  ][$status] ?? ['bg'=>'bg-slate-100','text'=>'text-slate-700','label'=>$status];
@endphp

<span {{ $attributes->merge(['class'=>"inline-flex items-center px-2.5 py-1 rounded-lg text-xs {$map['bg']} {$map['text']}"]) }}>
  {{ $map['label'] }}
</span>
