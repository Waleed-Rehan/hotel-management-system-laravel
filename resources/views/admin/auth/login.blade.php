<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تسجيل الدخول</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>
    :root{ --ink:#1b2b34; --accent:#0ea5a2; }
    html,body{font-family:'Cairo',system-ui,Arial; color:var(--ink); background:#fffdfa}
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-md bg-white rounded-2xl shadow p-6 border border-teal-50">
    <div class="flex items-center justify-between mb-2">
      <h1 class="text-2xl font-extrabold">تسجيل الدخول</h1>
      <a href="{{ route('landing') }}" class="text-sm text-teal-700 hover:underline">العودة للواجهة</a>
    </div>
    <p class="text-slate-500 mb-6">أدخل بيانات حسابك للمتابعة</p>

    @if ($errors->any())
      <div class="mb-4 rounded-xl bg-rose-50 text-rose-700 p-3 text-sm">
        <ul class="list-disc pr-6">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4" novalidate>
      @csrf

      <div>
        <label for="email" class="block text-sm mb-1">البريد الإلكتروني</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
               autocomplete="email"
               class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200 @error('email') border-rose-300 @enderror">
        @error('email')
          <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm mb-1">كلمة المرور</label>
        <input id="password" type="password" name="password" required
               autocomplete="current-password"
               class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-200 @error('password') border-rose-300 @enderror">
        @error('password')
          <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2 text-sm select-none">
          <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-200">
          تذكرني
        </label>
        <a href="{{ route('admin.register') }}" class="text-sm text-teal-700 hover:underline">إنشاء حساب</a>
      </div>

      <button type="submit"
              class="w-full rounded-xl bg-[var(--accent)] text-white py-2.5 font-bold hover:brightness-110">
        دخول
      </button>
    </form>
  </div>
</body>
</html>
