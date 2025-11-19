@props([
  'href' => route('landing'),
  'title' => 'نظام إدارة الفندق',
  'subtitle' => 'Hospitality Admin Suite',
  'compact' => false,      // keeps the wordmark hidden on xs when true
  'size' => 'lg',          // sm | md | lg | xl   ← bigger by default
])

@php
  // Emblem sizing
  $emblem = match($size) {
    'xl' => 'w-16 h-16 rounded-[22px]',
    'lg' => 'w-14 h-14 rounded-[20px]',
    'md' => 'w-12 h-12 rounded-2xl',
    default => 'w-10 h-10 rounded-xl', // sm
  };

  // Icon sizing
  $icon = match($size) {
    'xl' => 'w-8 h-8',
    'lg' => 'w-7 h-7',
    'md' => 'w-6 h-6',
    default => 'w-5 h-5', // sm
  };

  // Title sizing
  $titleSize = match($size) {
    'xl' => 'text-2xl md:text-3xl',
    'lg' => 'text-xl md:text-2xl',
    'md' => 'text-lg md:text-xl',
    default => 'text-base md:text-lg', // sm
  };

  // Subtitle sizing
  $subtitleSize = match($size) {
    'xl' => 'text-sm md:text-base',
    'lg' => 'text-xs md:text-sm',
    'md' => 'text-[11px] md:text-xs',
    default => 'text-[10px] md:text-[11px]', // sm
  };
@endphp

<a href="{{ $href }}" class="flex items-center gap-3 group select-none">
  {{-- Emblem --}}
  <span class="relative inline-flex items-center justify-center {{ $emblem }}
               ring-1 ring-teal-200/60 bg-gradient-to-br from-teal-50 to-amber-50
               shadow-sm overflow-hidden">
    <span class="absolute -inset-1 bg-gradient-to-br from-teal-300/10 to-amber-300/10 blur-md"></span>

    {{-- Bell mark (SVG) --}}
    <svg viewBox="0 0 48 48" aria-hidden="true"
         class="relative {{ $icon }} text-teal-700 group-hover:scale-105 transition-transform">
      <path d="M12 28c0-7.5 5.5-12 12-12s12 4.5 12 12" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
      <path d="M9 30h30" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
      <circle cx="24" cy="14" r="2.2" fill="currentColor"/>
      <rect x="14" y="31.5" width="20" height="3" rx="1.5"
            class="fill-amber-400/70 group-hover:fill-amber-500/80 transition-colors"></rect>
    </svg>
  </span>

  {{-- Wordmark --}}
  <span class="leading-tight {{ $compact ? 'hidden sm:block' : '' }}">
    <span class="block {{ $titleSize }} font-extrabold tracking-tight
                 bg-clip-text text-transparent bg-gradient-to-l from-teal-600 to-amber-600">
      {{ $title }}
    </span>
    @if($subtitle)
      <span class="block {{ $subtitleSize }} text-teal-900/55">
        {{ $subtitle }}
      </span>
    @endif
  </span>
</a>
