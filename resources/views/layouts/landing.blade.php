<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>نظام إدارة الفندق</title>
  <!-- Tailwind (CDN for dev) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Hospitality font -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>
    :root{
      --h-bg:#fff9f1;        /* warm ivory */
      --h-ink:#1b2b34;       /* deep teal ink */
      --h-accent:#0ea5a2;    /* teal accent */
      --h-accent-2:#f4a261;  /* soft amber */
      --h-gold:#c28f2c;      /* subtle gold */
    }
    html,body{font-family:'Cairo',system-ui,Arial; background:var(--h-bg); color:var(--h-ink)}
    @keyframes floaty {0%{transform:translateY(0)}50%{transform:translateY(-8px)}100%{transform:translateY(0)}}
    .floaty{animation: floaty 5s ease-in-out infinite}
    @keyframes rise {from{opacity:.0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)}}
    .rise{animation:rise .8s ease forwards}
  </style>
</head>
<body class="antialiased selection:bg-teal-200/50">
  <!-- NAVBAR -->
 <!-- NAVBAR -->
<header class="relative bg-transparent">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
    
    {{-- Brand (component) --}}
    <x-brand :compact="true" />

    {{-- Desktop links --}}
    <div class="hidden md:flex items-center gap-6 text-sm">
      <a href="#features" class="hover:text-[var(--h-accent)] transition">المميزات</a>
      <a href="#about" class="hover:text-[var(--h-accent)] transition">لماذا نحن</a>
      <a href="#contact" class="hover:text-[var(--h-accent)] transition">تواصل</a>

      @auth('web')
        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 rounded-xl bg-[var(--h-accent)] text-white hover:brightness-110 transition">
          لوحة التحكم
        </a>
        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
          @csrf
          <button class="px-4 py-2 rounded-xl bg-white border border-teal-200 text-[var(--h-ink)] hover:bg-teal-50 transition">
            تسجيل الخروج
          </button>
        </form>
      @else
        <a href="{{ route('admin.register') }}"
           class="px-4 py-2 rounded-xl bg-white border border-teal-200 text-[var(--h-ink)] hover:bg-teal-50 transition">
          إنشاء حساب
        </a>
        <a href="{{ route('admin.login') }}"
           class="px-4 py-2 rounded-xl bg-[var(--h-accent)] text-white hover:brightness-110 transition">
          تسجيل الدخول
        </a>
      @endauth
    </div>

    {{-- Mobile menu button --}}
    <button id="navToggle" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/70 ring-1 ring-teal-200 text-[var(--h-ink)]">
      ☰
    </button>
  </nav>

  {{-- Mobile menu panel --}}
  <div id="mobileMenu" class="md:hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4 hidden">
    <div class="rounded-2xl border border-teal-100 bg-white p-4 shadow-sm">
      <div class="flex flex-col gap-2 text-sm">
        <a href="#features" class="py-2 hover:text-[var(--h-accent)]">المميزات</a>
        <a href="#about" class="py-2 hover:text-[var(--h-accent)]">لماذا نحن</a>
        <a href="#contact" class="py-2 hover:text-[var(--h-accent)]">تواصل</a>
      </div>
      <div class="mt-3 border-t border-teal-100 pt-3 flex flex-col gap-2">
        @auth('web')
          <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-[var(--h-accent)] text-white text-center">لوحة التحكم</a>
          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full px-4 py-2 rounded-xl bg-white border border-teal-200 text-[var(--h-ink)]">تسجيل الخروج</button>
          </form>
        @else
          <a href="{{ route('admin.register') }}" class="px-4 py-2 rounded-xl bg-white border border-teal-200 text-[var(--h-ink)] text-center">إنشاء حساب</a>
          <a href="{{ route('admin.login') }}" class="px-4 py-2 rounded-xl bg-[var(--h-accent)] text-white text-center">تسجيل الدخول</a>
        @endauth
      </div>
    </div>
  </div>
</header>

{{-- tiny toggle script (no framework) --}}
<script>
  const t = document.getElementById('navToggle');
  const m = document.getElementById('mobileMenu');
  if (t && m) t.addEventListener('click', () => m.classList.toggle('hidden'));
</script>

    <!-- top wave -->
    <div class="absolute inset-x-0 -top-24 -z-10 opacity-70">
      <svg viewBox="0 0 1440 320" class="w-full h-32 text-teal-100" fill="currentColor" preserveAspectRatio="none">
        <path d="M0,64L40,85.3C80,107,160,149,240,154.7C320,160,400,128,480,122.7C560,117,640,139,720,165.3C800,192,880,224,960,234.7C1040,245,1120,235,1200,213.3C1280,192,1360,160,1400,144L1440,128L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z"/>
      </svg>
    </div>
  </header>

  <!-- HERO -->
  <section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-2 md:pt-8 lg:pt-12">
      <div class="grid lg:grid-cols-2 gap-10 items-center">
        <!-- text -->
        <div class="order-2 lg:order-1 rise">
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
            إدارة فندقية <span class="bg-clip-text text-transparent bg-gradient-to-l from-[var(--h-accent)] to-[var(--h-accent-2)]">أنيقة</span>
            تُرحّب بضيوفك قبل الوصول
          </h1>
          <p class="mt-4 text-[var(--h-ink)]/70 text-lg leading-relaxed">
            لوحة تحكم دافئة ومرحِّبة لإدارة الغرف، الحجوزات، الخدمات والتقارير — بتجربة بصرية مريحة تعكس ضيافتك.
          </p>

          <!-- UPDATED: Login & Register buttons -->
      <!-- Auth-aware hero buttons -->
<!-- Auth-aware hero buttons -->
<div class="mt-8 flex flex-wrap items-center gap-3">
  @auth('web')
    <a href="{{ route('admin.dashboard') }}"
       class="px-5 py-3 rounded-2xl bg-[var(--h-accent)] text-white hover:brightness-110">
      لوحة التحكم
    </a>

    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
      @csrf
      <button type="submit"
              class="px-5 py-3 rounded-2xl bg-white border border-teal-200 text-[var(--h-ink)] hover:bg-teal-50">
        تسجيل الخروج
      </button>
    </form>
  @else
    <a href="{{ route('admin.login') }}"
       class="px-5 py-3 rounded-2xl bg-[var(--h-accent)] text-white hover:brightness-110">
      تسجيل الدخول
    </a>

    <a href="{{ route('admin.register') }}"
       class="px-5 py-3 rounded-2xl bg-white border border-teal-200 text-[var(--h-ink)] hover:bg-teal-50">
      إنشاء حساب
    </a>
  @endauth
</div>

  
          <!-- hospitality chips -->
          <div class="mt-8 flex flex-wrap gap-2">
            <span class="floaty delay-0 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-teal-50 text-[var(--h-ink)] text-sm border border-teal-100">🛏️ إدارة الغرف</span>
            <span class="floaty delay-200 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-amber-50 text-[var(--h-ink)] text-sm border border-amber-100">🧳 الحجوزات</span>
            <span class="floaty delay-300 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-rose-50 text-[var(--h-ink)] text-sm border border-rose-100">🧼 التدبير</span>
            <span class="floaty delay-500 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-sky-50 text-[var(--h-ink)] text-sm border border-sky-100">📊 التقارير</span>
          </div>
        </div>

        <!-- image card -->
        <div class="order-1 lg:order-2">
          <div class="relative rounded-[28px] overflow-hidden shadow-xl ring-1 ring-teal-100 bg-white">
            <img src="{{ asset('images/lobby.jpg') }}" alt="Luxury hotel lobby" class="w-full h-[360px] md:h-[460px] object-cover">
            <!-- overlay circles -->
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-[var(--h-accent)]/15 rounded-full blur-2xl"></div>
            <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-[var(--h-accent-2)]/20 rounded-full blur-2xl"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- bottom wave separator -->
    <div class="mt-14">
      <svg viewBox="0 0 1440 180" class="w-full h-24 text-white" fill="currentColor" preserveAspectRatio="none">
        <path d="M0,160L80,144C160,128,320,96,480,96C640,96,800,128,960,128C1120,128,1280,96,1360,80L1440,64L1440,180L1360,180C1280,180,1120,180,960,180C800,180,640,180,480,180C320,180,160,180,80,180L0,180Z"/>
      </svg>
    </div>
  </section>

  <!-- FEATURES -->
  <!-- FEATURES -->
<section id="features" class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <!-- Heading -->
    <div class="text-center">
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                   bg-teal-50 text-teal-700 border border-teal-100">
        المزايا الرئيسية
      </span>
      <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-[var(--h-ink)]">
        مميزات النظام
      </h2>
      <p class="mt-3 text-[var(--h-ink)]/70 max-w-2xl mx-auto">
        أدوات عملية مصممة للضيافة: سريعة، مريحة بصريًا، وقابلة للتوسع.
      </p>
    </div>

    <!-- Grid -->
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <x-landing.card
          :href="auth()->check() ? route('admin.rooms.index') : route('admin.login')"
          title="الغرف">
        <div class="flex items-start gap-3">
          <span class="text-3xl leading-none">🛏️</span>
          <p class="text-sm text-[var(--h-ink)]/70">إدارة الأنواع، الحالة والتسعير مع رؤية فورية للإشغال.</p>
        </div>
      </x-landing.card>
    
      <x-landing.card
          :href="auth()->check() ? route('admin.reservations.index') : route('admin.login')"
          title="الحجوزات">
        <div class="flex items-start gap-3">
          <span class="text-3xl leading-none">🧳</span>
          <p class="text-sm text-[var(--h-ink)]/70">حجز، تعديل، وتسجيل الوصول/المغادرة خلال ثوانٍ.</p>
        </div>
      </x-landing.card>
    
      <x-landing.card
          :href="auth()->check() ? route('admin.housekeeping.index') : route('admin.login')"
          title="الخدمات">
        <div class="flex items-start gap-3">
          <span class="text-3xl leading-none">🧼</span>
          <p class="text-sm text-[var(--h-ink)]/70">متابعة أعمال التنظيف والصيانة بدقة وبساطة.</p>
        </div>
      </x-landing.card>
    
      <x-landing.card
          :href="auth()->check() ? route('admin.reports.index') : route('admin.login')"
          title="التقارير">
        <div class="flex items-start gap-3">
          <span class="text-3xl leading-none">📊</span>
          <p class="text-sm text-[var(--h-ink)]/70">أرباح وخسائر، سجل سنوي، وملخص الصندوق بمؤشرات واضحة.</p>
        </div>
      </x-landing.card>
    </div>
    
    <!-- Stats strip -->
    <div class="mt-16 grid gap-4 sm:grid-cols-3">
      <div class="rounded-2xl bg-teal-50 p-5 text-center border border-teal-100">
        <div class="text-2xl font-extrabold text-[var(--h-ink)]">+99.9%</div>
        <div class="text-[var(--h-ink)]/60 text-sm">جاهزية النظام</div>
      </div>
      <div class="rounded-2xl bg-amber-50 p-5 text-center border border-amber-100">
        <div class="text-2xl font-extrabold text-[var(--h-ink)]" dir="ltr">24/7</div>
        <div class="text-[var(--h-ink)]/60 text-sm">دعم وموثوقية</div>
      </div>
      <div class="rounded-2xl bg-rose-50 p-5 text-center border border-rose-100">
        <div class="text-2xl font-extrabold text-[var(--h-ink)]">3×</div>
        <div class="text-[var(--h-ink)]/60 text-sm">سرعة التنفيذ</div>
      </div>
    </div>

    <!-- CTA row -->
   
  </div>
</section>

  <!-- FOOTER -->
  <footer id="contact" class="bg-white border-t border-teal-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10 grid md:grid-cols-3 gap-8 items-center">
      <div>
        <div class="text-lg font-extrabold text-[var(--h-ink)]">نظام إدارة الفندق</div>
        <p class="mt-2 text-[var(--h-ink)]/60 text-sm">واجهة مُرحِّبة لإدارة الضيافة — بسيطة، هادئة، وأنيقة.</p>
      </div>
      <div class="md:text-center">
        <!-- Footer CTA -> Login -->
        <a href="{{ auth()->check() ? route('admin.dashboard') : route('admin.login') }}"
          class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-[var(--h-accent)] text-white hover:brightness-110 shadow-sm">
         ابدأ الاستخدام الآن
       </a>
       
             </div>
      <div class="md:text-left text-[var(--h-ink)]/60 text-sm">© {{ now()->year }} جميع الحقوق محفوظة</div>
    </div>
  </footer>
</body>
</html>
