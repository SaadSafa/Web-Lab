@extends('layouts.app')
@section('title', "Order #{$rec->id}")

@php
  $pill = [
    'pending' => 'bg-amber-500/15 text-amber-200 border-amber-500/20',
    'preparing' => 'bg-sky-500/15 text-sky-200 border-sky-500/20',
    'ready' => 'bg-emerald-500/15 text-emerald-200 border-emerald-500/20',
    'picked_up' => 'bg-slate-500/15 text-slate-200 border-slate-500/20',
    'cancelled' => 'bg-rose-500/15 text-rose-200 border-rose-500/20',
  ][$rec->status] ?? 'bg-white/10 text-cream-soft border-white/10';
@endphp

@section('content')
<div class="flex flex-wrap items-start justify-between gap-6 mb-8">
  <div>
    <p class="text-xs uppercase tracking-widest text-cream-faint mb-2">Order detail</p>
    <h1 class="text-3xl font-display">Order #{{ $rec->id }}</h1>
    <p class="text-cream-muted text-sm">Customer: <span class="text-cream-100">{{ $rec->customer_name ?? 'Walk-in' }}</span></p>
  </div>

  <span class="inline-flex items-center rounded-full border px-4 py-2 text-sm {{ $pill }}">
    {{ strtoupper($rec->status) }}
  </span>
</div>

<div class="grid gap-6 lg:grid-cols-3">
  <div class="lg:col-span-2 table-shell">
    <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
      <h2 class="font-display text-lg">Items</h2>
      <div class="text-cream-muted text-sm">{{ $rec->items->count() }} line(s)</div>
    </div>

    <table class="w-full text-sm">
      <thead class="bg-white/5 text-cream-soft">
        <tr>
          <th class="text-left px-5 py-3">Item</th>
          <th class="text-right px-5 py-3">Qty</th>
          <th class="text-right px-5 py-3">Unit</th>
          <th class="text-right px-5 py-3">Line</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-white/10">
        @foreach($rec->items as $it)
        <tr class="hover:bg-white/5 transition">
          <td class="px-5 py-3 font-medium">{{ $it->menuItem->name }}</td>
          <td class="px-5 py-3 text-right">{{ $it->qty }}</td>
          <td class="px-5 py-3 text-right">${{ number_format($it->unit_price,2) }}</td>
          <td class="px-5 py-3 text-right font-semibold">${{ number_format($it->line_total,2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="px-5 py-4 border-t border-white/10 flex items-center justify-between">
      <span class="text-cream-muted">Total</span>
      <span class="text-2xl font-display">${{ number_format($rec->total,2) }}</span>
    </div>
  </div>

  <div class="glass-panel p-5">
    <h2 class="font-display text-lg mb-1">Update Status</h2>
    <p class="text-cream-muted text-sm mb-4">This controls what appears on the queue screen.</p>

    <form method="POST" action="{{ route('orders.status', $rec->id) }}" class="space-y-3">
      @csrf

      <select name="status"
              class="w-full rounded-2xl bg-slate-950/40 border border-white/10 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-300/40">
        @foreach(['pending','preparing','ready','picked_up','cancelled'] as $st)
          <option value="{{ $st }}" {{ $rec->status===$st ? 'selected' : '' }}>
            {{ strtoupper($st) }}
          </option>
        @endforeach
      </select>

      <button type="submit" class="btn-primary w-full">
        Save
      </button>
    </form>

    <div class="mt-5 text-xs text-cream-faint">
      Tip: set to <span class="text-cream-100">READY</span> to show it in green on the queue.
    </div>
  </div>
</div>
@endsection
