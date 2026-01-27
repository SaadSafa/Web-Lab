@extends('layouts.app')
@section('title','Menu Items')

@section('content')
<div class="flex flex-wrap items-start justify-between gap-4 mb-8">
  <div>
    <p class="text-xs uppercase tracking-widest text-cream-faint mb-2">Catalog</p>
    <h1 class="text-3xl font-display">Menu Items</h1>
    <p class="text-cream-muted text-sm">Manage what customers can order.</p>
  </div>

  <a href="{{ route('menu-items.create') }}" class="btn-primary">
    + Add Item
  </a>
</div>

<div class="table-shell">
  <table class="w-full text-sm">
    <thead class="bg-white/5 text-cream-soft">
      <tr>
        <th class="text-left px-4 py-3">Name</th>
        <th class="text-left px-4 py-3">Price</th>
        <th class="text-left px-4 py-3">Status</th>
        <th class="text-right px-4 py-3">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-white/10">
      @foreach($record as $rec)
      <tr class="hover:bg-white/5 transition">
        <td class="px-4 py-3 font-medium">{{ $rec->name }}</td>
        <td class="px-4 py-3 text-cream-100">${{ number_format($rec->price,2) }}</td>
        <td class="px-4 py-3">
          @if($rec->is_available)
            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/15 px-3 py-1 text-emerald-200 border border-emerald-500/20">
              <span class="h-2 w-2 rounded-full bg-emerald-400"></span> Available
            </span>
          @else
            <span class="inline-flex items-center gap-2 rounded-full bg-rose-500/15 px-3 py-1 text-rose-200 border border-rose-500/20">
              <span class="h-2 w-2 rounded-full bg-rose-400"></span> Unavailable
            </span>
          @endif
        </td>
        <td class="px-4 py-3">
          <div class="flex justify-end gap-2">
            <a href="{{ route('menu-items.edit',$rec->id) }}" class="btn-ghost bg-white/10">
              Edit
            </a>

            <form action="{{ route('menu-items.destroy',$rec->id) }}" method="POST">
              @csrf
              <button type="submit" onclick="return confirm('Delete this item?')"
                      class="btn-ghost border border-rose-500/20 text-rose-200 bg-rose-500/10 hover:bg-rose-500/20">
                Delete
              </button>
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-6">
</div>
@endsection
