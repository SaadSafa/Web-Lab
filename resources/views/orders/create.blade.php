@extends('layouts.app')

@section('content')
<div class="flex flex-wrap items-start justify-between gap-4 mb-8">
  <div>
    <p class="text-xs uppercase tracking-widest text-cream-faint mb-2">New ticket</p>
    <h1 class="text-3xl font-display">Create Order</h1>
    <p class="text-cream-muted text-sm">Add items and send to the queue.</p>
  </div>
</div>

@if($errors->any())
  <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-rose-200">
    <ul class="list-disc pl-5">
      @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('orders.store') }}" class="grid gap-6 lg:grid-cols-3">
  @csrf

  <div class="lg:col-span-2 glass-panel p-6">
    <h2 class="font-display text-lg mb-4">Order Details</h2>

    <div class="mb-6">
      <label class="field-label">Customer name (optional)</label>
      <input class="input-base" name="customer_name" value="{{ old('customer_name') }}" placeholder="Walk-in or name">
    </div>

    <div class="flex items-center justify-between mb-3">
      <h3 class="font-display text-base">Items</h3>
      <button type="button" onclick="addRow()" class="btn-ghost bg-white/10">+ Add item</button>
    </div>

    <div id="rows" class="flex flex-col gap-3">
      <div class="row flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px]">
          <select name="items[0][menu_item_id]" class="select-base">
            @foreach($record as $mi)
              <option value="{{ $mi->id }}">{{ $mi->name }} (${{ number_format($mi->price,2) }})</option>
            @endforeach
          </select>
        </div>
        <div class="w-24">
          <input name="items[0][qty]" type="number" min="1" value="1" class="input-base">
        </div>
        <button type="button" onclick="removeRow(this)" class="btn-ghost border border-rose-500/20 text-rose-200 bg-rose-500/10 hover:bg-rose-500/20">
          Remove
        </button>
      </div>
    </div>
  </div>

  <div class="glass-panel p-6 h-fit">
    <h2 class="font-display text-lg mb-2">Actions</h2>
    <p class="text-cream-muted text-sm mb-5">Submit when you are ready to send to the kitchen.</p>
    <button type="submit" class="btn-primary w-full">Create Order</button>
  </div>
</form>

<script>
let i = 1;

function addRow(){
  const rows = document.getElementById('rows');
  const div = document.createElement('div');
  div.className = 'row flex flex-wrap items-center gap-3';

  div.innerHTML = `
    <div class="flex-1 min-w-[200px]">
      <select name="items[${i}][menu_item_id]" class="select-base">
        @foreach($record as $mi)
          <option value="{{ $mi->id }}">{{ $mi->name }} (${{ number_format($mi->price,2) }})</option>
        @endforeach
      </select>
    </div>
    <div class="w-24">
      <input name="items[${i}][qty]" type="number" min="1" value="1" class="input-base">
    </div>
    <button type="button" onclick="removeRow(this)" class="btn-ghost border border-rose-500/20 text-rose-200 bg-rose-500/10 hover:bg-rose-500/20">
      Remove
    </button>
  `;

  rows.appendChild(div);
  i++;
}

function removeRow(btn){
  const rows = document.getElementById('rows');
  if(rows.children.length === 1) return;
  btn.parentElement.remove();
}
</script>
@endsection
