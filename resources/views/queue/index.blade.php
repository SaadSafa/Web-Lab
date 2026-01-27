@extends('layouts.app')
@section('title','Queue Screen')

@section('content')
<div class="flex flex-wrap items-end justify-between gap-6 mb-8">
  <div>
    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-cream-soft mb-3">
      <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
      Live queue feed
    </div>
    <h1 class="text-4xl font-display tracking-tight">
      Queue Screen
    </h1>
    <p class="text-cream-muted">Auto-refresh every 10 seconds - Show this on a TV.</p>
  </div>

  <div class="glass-panel px-4 py-3 text-xs text-cream-soft">
    Last refresh: <span id="t" class="text-cream-100"></span>
  </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
  <section class="glass-panel p-6 border-sky-400/20 bg-gradient-to-b from-sky-400/10 to-white/5">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="font-display text-xl text-sky-100">Now Preparing</h2>
        <p class="text-xs text-cream-muted">Orders in production</p>
      </div>
      <span class="text-xs text-cream-muted">{{ $preparing->count() }} order(s)</span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
      @forelse($preparing as $o)
        <div class="rounded-3xl border border-sky-400/25 bg-slate-950/30 p-5 text-center shadow-lg shadow-sky-400/10">
          <div class="text-cream-faint text-xs mb-1">ORDER</div>
          <div class="text-4xl font-black tracking-tight text-sky-100">#{{ $o->id }}</div>
        </div>
      @empty
        <div class="text-cream-muted">No orders preparing.</div>
      @endforelse
    </div>
  </section>

  <section class="glass-panel p-6 border-emerald-400/20 bg-gradient-to-b from-emerald-400/10 to-white/5">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="font-display text-xl text-emerald-100">Ready for Pickup</h2>
        <p class="text-xs text-cream-muted">Calling customers now</p>
      </div>
      <span class="text-xs text-cream-muted">{{ $ready->count() }} order(s)</span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
      @forelse($ready as $o)
        <div class="rounded-3xl border border-emerald-400/25 bg-slate-950/30 p-5 text-center shadow-lg shadow-emerald-400/10">
          <div class="text-cream-faint text-xs mb-1">READY</div>
          <div class="text-4xl font-black tracking-tight text-emerald-100">#{{ $o->id }}</div>
        </div>
      @empty
        <div class="text-cream-muted">No orders ready.</div>
      @endforelse
    </div>
  </section>
</div>

<script>
  document.getElementById('t').textContent = new Date().toLocaleTimeString();
  setTimeout(() => location.reload(), 10000);
</script>
@endsection
