@php
  $is   = fn($p) => request()->routeIs($p) ? 'bg-slate-100 font-bold aria-[current=page]:font-bold' : '';
  $aria = fn($p) => request()->routeIs($p) ? 'page' : 'false';
  $link = 'flex items-center justify-between px-3 py-2 rounded-xl hover:bg-slate-50
           focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-300 transition';
  $sectionTitle = 'mt-6 mb-2 px-2 text-[11px] font-bold tracking-widest text-slate-400';
  // closeExpr is passed from parent to close the drawer on mobile after click
@endphp

{{-- OPERATIONS --}}
<div class="{{ $sectionTitle }}">العمليات</div>
<nav class="space-y-1 text-sm">
  <a href="{{ route('admin.dashboard') }}" class="{{ $link }} {{ $is('admin.dashboard') }}" aria-current="{{ $aria('admin.dashboard') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>لوحة التحكم</span><span role="img" aria-label="الصفحة الرئيسية">🏠</span>
  </a>

  <a href="{{ route('admin.rooms.index') }}" class="{{ $link }} {{ $is('admin.rooms.*') }}" aria-current="{{ $aria('admin.rooms.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>الغرف</span><span role="img" aria-label="الغرف">🛏️</span>
  </a>

  <a href="{{ route('admin.room-types.index') }}" class="{{ $link }} {{ $is('admin.room-types.*') }}" aria-current="{{ $aria('admin.room-types.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>أنواع الغرف</span><span role="img" aria-label="الوسوم">🏷️</span>
  </a>

  <a href="{{ route('admin.reservations.index') }}" class="{{ $link }} {{ $is('admin.reservations.*') }}" aria-current="{{ $aria('admin.reservations.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>الحجوزات</span><span role="img" aria-label="الحجوزات">🧳</span>
  </a>

  <a href="{{ route('admin.guests.index') }}" class="{{ $link }} {{ $is('admin.guests.*') }}" aria-current="{{ $aria('admin.guests.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>الضيوف</span><span role="img" aria-label="الضيوف">👤</span>
  </a>

  <a href="{{ route('admin.housekeeping.index') }}" class="{{ $link }} {{ $is('admin.housekeeping.*') }}" aria-current="{{ $aria('admin.housekeeping.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>التنظيف</span><span role="img" aria-label="التنظيف">🧼</span>
  </a>

  <a href="{{ route('admin.maintenance.index') }}" class="{{ $link }} {{ $is('admin.maintenance.*') }}" aria-current="{{ $aria('admin.maintenance.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>الصيانة</span><span role="img" aria-label="الصيانة">🛠️</span>
  </a>
</nav>

{{-- PEOPLE --}}
<div class="{{ $sectionTitle }}">الموارد البشرية</div>
<nav class="space-y-1 text-sm">
  <a href="{{ route('admin.employees.index') }}" class="{{ $link }} {{ $is('admin.employees.*') }}" aria-current="{{ $aria('admin.employees.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>إدارة الموظفين</span><span role="img" aria-label="الموظفون">🧑‍💼</span>
  </a>

  <a href="{{ route('admin.groups.index') }}" class="{{ $link }} {{ $is('admin.groups.*') }}" aria-current="{{ $aria('admin.groups.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>المجموعات</span><span role="img" aria-label="المجموعات">👥</span>
  </a>

  
</nav>

{{-- FINANCE & REPORTS --}}
<div class="{{ $sectionTitle }}">المالية والتقارير</div>
<nav class="space-y-1 text-sm">
  <a href="{{ route('admin.finance.index') }}" class="{{ $link }} {{ $is('admin.finance.*') }}" aria-current="{{ $aria('admin.finance.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>المالية</span><span role="img" aria-label="المالية">💳</span>
  </a>

  <a href="{{ route('admin.reports.index') }}" class="{{ $link }} {{ $is('admin.reports.*') }}" aria-current="{{ $aria('admin.reports.*') }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>التقارير</span><span role="img" aria-label="التقارير">📊</span>
  </a>
</nav>

{{-- Footer --}}
<div class="mt-8 border-t pt-4 text-sm">
  <a href="{{ route('landing') }}" class="{{ $link }}"
     @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
    <span>العودة للواجهة</span><span>↩️</span>
  </a>
  <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
    @csrf
    <button type="submit" class="w-full text-left {{ $link }} text-rose-700 hover:text-rose-800"
            @if(!empty($closeExpr)) @click="{{ $closeExpr }}" @endif>
      <span>تسجيل الخروج</span><span>🚪</span>
    </button>
  </form>
</div>
