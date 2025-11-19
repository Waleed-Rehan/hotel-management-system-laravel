@props([
  'href' => '#',
  'title' => '',
  'icon' => '📊',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block group']) }}>
  <div class="rounded-3xl p-6 border transition backdrop-blur
              border-teal-100/60 bg-white/40
              hover:shadow-md hover:-translate-y-1">
    <div class="flex items-start gap-3">
      <span class="text-3xl leading-none">{{ $icon }}</span>
      <div>
        <h5 class="mb-1 font-extrabold text-[var(--ink)]">
          <span class="bg-clip-text text-transparent bg-gradient-to-l from-teal-600 to-amber-600">
            {{ $title }}
          </span>
        </h5>
        <p class="text-sm text-[var(--ink)]/70 mb-0">{{ $slot }}</p>
      </div>
    </div>
  </div>
</a>
