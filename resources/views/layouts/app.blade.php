<!doctype html>
<html lang="en" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Cafe Queue')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#0b0b0d"
  @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@500;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  @vite(['resources/js/app.js'])
</head>

<body class="h-full text-cream-100 bg-ambient">
  <div class="fixed inset-0 pointer-events-none opacity-60">
    <div class="absolute -top-20 -left-10 h-72 w-72 rounded-full bg-teal-400/10 blur-3xl"></div>
    <div class="absolute top-10 right-0 h-80 w-80 rounded-full bg-amber-300/10 blur-3xl"></div>
  </div>

  <header class="sticky top-0 z-50 border-b border-white/10 bg-[#0b0b0d]/70 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="h-11 w-11 rounded-2xl bg-gradient-to-br from-amber-300 to-teal-300 grid place-items-center shadow-lg shadow-amber-300/30">
          <span class="text-espresso-950 font-black">CQ</span>
        </div>
        <div>
          <p class="font-display text-lg leading-5">Cafe Queue</p>
          <p class="text-xs text-cream-muted">Orders - Menu - Queue Screen</p>
        </div>
      </div>

      <nav class="flex items-center gap-2">
        <a href="{{ route('orders.index') }}" class="btn-ghost">Orders</a>
        <a href="{{ route('orders.create') }}" class="btn-ghost">New Order</a>
        <a href="{{ route('menu-items.index') }}" class="btn-ghost">Menu</a>
        <a href="{{ route('queue') }}" class="btn-ghost bg-white/10">Queue</a>
      </nav>
    </div>
  </header>

  <main class="mx-auto max-w-6xl px-4 py-10 relative">
    @if(session('success'))
      <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-emerald-200">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>
</body>
</html>
