<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>التقارير</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>
    :root{ --ink:#1b2b34; --accent:#0ea5a2; }
    html,body{font-family:'Cairo',system-ui,Arial; color:var(--ink); background:#fffdfa}
  </style>
</head>
<body class="min-h-screen bg-white">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <x-brand size="md" :compact="true" />
        <div>
          <h1 class="text-2xl font-extrabold">التقارير</h1>
          <p class="text-sm text-slate-500">لوحة تقارير مالية وتشغيلية للفندق</p>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 rounded-xl bg-[var(--accent)] text-white hover:brightness-110">لوحة التحكم</a>
      </div>
    </div>

    {{-- Quick filters / toolbar (optional) --}}
    <div class="mt-6 rounded-2xl border border-teal-100 bg-teal-50/40 p-4">
      <div class="flex flex-wrap items-center gap-3 text-sm">
        <span class="text-slate-600">اختيار الفترة:</span>
        <input type="date" class="rounded-lg border border-slate-200 px-3 py-2">
        <input type="date" class="rounded-lg border border-slate-200 px-3 py-2">
        <button class="px-4 py-2 rounded-lg bg-white border border-teal-200 text-[var(--ink)] hover:bg-teal-50">تطبيق</button>
      </div>
    </div>

    @php
      $reports = [
        [
          'route' => 'admin.reports.profit-loss',
          'title' => 'الأرباح والخسائر',
          'icon'  => '📊',
          'desc'  => 'نظرة عامة على الإيرادات والمصروفات وصافي الربح ضمن فترة محددة.',
          'class' => 'hover:border-sky-300 hover:bg-sky-50'
        ],
        [
          'route' => 'admin.reports.annual-ledger',
          'title' => 'السجل السنوي',
          'icon'  => '📘',
          'desc'  => 'كشف سنوي للحركات المالية مع إمكانية التصدير.',
          'class' => 'hover:border-amber-300 hover:bg-amber-50'
        ],
        [
          'route' => 'admin.reports.cashbox',
          'title' => 'ملخص الصندوق',
          'icon'  => '💼',
          'desc'  => 'رصد لحظي لإيرادات ونفقات الصندوق وحالة الرصيد.',
          'class' => 'hover:border-teal-300 hover:bg-teal-50'
        ],
      ];
    @endphp

    {{-- Report cards --}}
    <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($reports as $r)
        <x-report.card
          :href="route($r['route'])"
          :title="$r['title']"
          :icon="$r['icon']"
          :class="$r['class']"
        >
          {{ $r['desc'] }}
        </x-report.card>
      @endforeach
    </div>
  </div>
</body>
</html>
