@extends('layouts.app')

@section('content')
<div class="flex flex-wrap items-start justify-between gap-4 mb-8">
  <div>
    <p class="text-xs uppercase tracking-widest text-cream-faint mb-2">Operations</p>
    <h1 class="text-3xl font-display">Orders</h1>
    <p class="text-cream-muted text-sm">Track and manage the live queue.</p>
  </div>

  <a href="{{ route('orders.create') }}" class="btn-primary">
    + New Order
  </a>
</div>

<div class="flex flex-wrap gap-2 mb-6">
  <a href="{{ route('orders.index') }}" class="badge-muted">All</a>
  <a href="{{ route('orders.index', ['status'=>'pending']) }}" class="badge-muted">Pending</a>
  <a href="{{ route('orders.index', ['status'=>'preparing']) }}" class="badge-muted">Preparing</a>
  <a href="{{ route('orders.index', ['status'=>'ready']) }}" class="badge-muted">Ready</a>
  <a href="{{ route('orders.index', ['status'=>'picked_up']) }}" class="badge-muted">Picked Up</a>
  <a href="{{ route('orders.index', ['status'=>'cancelled']) }}" class="badge-muted">Cancelled</a>
</div>

<div class="table-shell">
  <table class="w-full text-sm">
    <thead class="bg-white/5 text-cream-soft">
      <tr>
        <th class="text-left px-5 py-3">#</th>
        <th class="text-left px-5 py-3">Customer</th>
        <th class="text-left px-5 py-3">Status</th>
        <th class="text-left px-5 py-3">Total</th>
        <th class="text-left px-5 py-3">Created</th>
        <th class="text-right px-5 py-3">Action</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-white/10">
      @foreach($record as $rec)
      <tr class="hover:bg-white/5 transition">
        <td class="px-5 py-3 font-medium">#{{ $rec->id }}</td>
        <td class="px-5 py-3">{{ $rec->customer_name ?? 'Walk-in' }}</td>
        <td class="px-5 py-3 capitalize text-cream-soft">{{ str_replace('_',' ',$rec->status) }}</td>
        <td class="px-5 py-3">${{ number_format($rec->total, 2) }}</td>
        <td class="px-5 py-3 text-cream-soft">{{ $rec->created_at->format('Y-m-d H:i') }}</td>
        <td class="px-5 py-3 text-right">
          <a href="{{ route('orders.show', $rec->id) }}" class="btn-ghost bg-white/10">
            View
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-6">
</div>
@endsection
