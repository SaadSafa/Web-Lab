@extends('layouts.app')
@section('content')
<div class="flex flex-wrap items-start justify-between gap-4 mb-8">
  <div>
    <p class="text-xs uppercase tracking-widest text-cream-faint mb-2">Catalog</p>
    <h1 class="text-3xl font-display">Add Menu Item</h1>
    <p class="text-cream-muted text-sm">Create a new item for the menu.</p>
  </div>
</div>

<form method="POST" action="{{ route('menu-items.store') }}" class="glass-panel p-6 max-w-xl">
  @csrf
  <div class="mb-5">
    <label class="field-label">Name</label>
    <input name="name" value="{{ old('name') }}" class="input-base" placeholder="Cappuccino">
    @error('name') <div class="text-rose-200 text-sm mt-2">{{ $message }}</div> @enderror
  </div>

  <div class="mb-5">
    <label class="field-label">Price</label>
    <input name="price" type="number" step="0.01" value="{{ old('price') }}" class="input-base" placeholder="4.50">
    @error('price') <div class="text-rose-200 text-sm mt-2">{{ $message }}</div> @enderror
  </div>

  <label class="inline-flex items-center gap-3 text-cream-soft mb-6">
    <input type="checkbox" name="is_available" checked class="h-4 w-4 rounded border-white/20 bg-slate-950/40 text-emerald-400 focus:ring-emerald-400/40">
    Available
  </label>

  <button type="submit" class="btn-primary w-full">Save</button>
</form>
@endsection
