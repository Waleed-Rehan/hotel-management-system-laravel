@props(['mobileVar' => 'openSidebar'])

{{-- =================== MOBILE (drawer) =================== --}}
{{-- Backdrop --}}
<div x-cloak class="lg:hidden fixed inset-0 z-40"
     x-show="{{ $mobileVar }}"
     x-transition.opacity
     @click="{{ $mobileVar }} = false"
     style="background: rgba(15,23,42,.45); backdrop-filter: blur(2px);">
</div>

{{-- Drawer --}}
<aside x-cloak
       class="lg:hidden fixed inset-y-0 right-0 w-72 z-50 bg-white border-l border-slate-200
              overflow-y-auto scroll-slim transform transition-transform duration-300 ease-in-out"
       x-show="{{ $mobileVar }}"
       :class="{ 'translate-x-0': {{ $mobileVar }}, 'translate-x-full': !({{ $mobileVar }}) }"
       @keydown.escape.window="{{ $mobileVar }} = false">
  <div class="flex items-center justify-between px-4 pt-4">
    <x-brand size="md" />
    <button type="button"
            class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-sm hover:bg-slate-50"
            @click="{{ $mobileVar }} = false">إغلاق ✕</button>
  </div>

  @include('components.admin.sidebar._menu', ['closeExpr' => $mobileVar.' = false'])
</aside>

{{-- =================== DESKTOP (static column) =================== --}}
<aside class="hidden lg:block bg-white border-slate-200 border-r rtl:border-l rtl:border-r-0
               h-screen sticky top-0 py-6 px-5 overflow-y-auto scroll-slim">
  <div class="flex items-center gap-3 px-2">
    <x-brand size="lg" />
  </div>

  @include('components.admin.sidebar._menu', ['closeExpr' => '']) {{-- no-op on desktop --}}
</aside>
