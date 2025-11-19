<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','لوحة التحكم')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine for the mobile drawer -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>
    :root{ --ink:#0f172a; --muted:#64748b; --accent:#0ea5a2; }
    html,body{font-family:'Cairo',system-ui,Arial}
    .scroll-slim::-webkit-scrollbar{width:8px;height:8px}
    .scroll-slim::-webkit-scrollbar-thumb{background:#e2e8f0;border-radius:999px}
    [x-cloak]{ display:none !important; }
  </style>
  @stack('head')
</head>
<body class="bg-slate-50 text-[var(--ink)]" x-data="{ openSidebar:false }">
  {{-- Grid: on desktop we reserve a fixed column for the sidebar --}}
  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[280px_1fr]">

    {{-- SIDEBAR (component outputs BOTH: mobile drawer + desktop static) --}}
    <x-admin.sidebar mobile-var="openSidebar" />

    {{-- MAIN --}}
    <main class="p-4 lg:p-8">
      {{-- Mobile top bar with menu button --}}
      <div class="mb-4 lg:hidden flex items-center justify-between">
        <button type="button"
                @click="openSidebar = true"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50">
          <span>القائمة</span> <span aria-hidden="true">☰</span>
        </button>
        <div class="text-sm text-[var(--muted)]">{{ auth()->user()?->name }}</div>
      </div>

      {{-- Top bar (desktop) --}}
      <div class="hidden lg:flex items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-extrabold">@yield('page_title','لوحة التحكم')</h1>
          <p class="text-sm text-[var(--muted)]">@yield('page_subtitle','نظرة عامة سريعة على النظام')</p>
        </div>
        <div class="flex items-center gap-3">
          <div class="text-sm text-[var(--muted)]">{{ auth()->user()?->name }}</div>
          <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center">👤</div>
        </div>
      </div>

      {{-- Content --}}
      <div class="mt-6">
        @yield('content')
      </div>
    </main>
  </div>

  @stack('scripts')
</body>
</html>
