@props(['title', 'href', 'class' => ''])

<a href="{{ $href }}" class="block group">
  <div class="rounded-3xl p-6 border transition backdrop-blur
              border-teal-100/60 bg-white/40
              hover:border-teal-300 hover:bg-teal-50 hover:shadow-md hover:-translate-y-1 {{ $class }}">
    <h5 class="mb-2 font-extrabold text-[var(--h-ink)]">
      <span class="bg-clip-text text-transparent bg-gradient-to-l from-teal-600 to-amber-600">
        {{ $title }}
      </span>
    </h5>
    <p class="text-sm text-[var(--h-ink)]/70 mb-0">{{ $slot }}</p>
  </div>
</a>
