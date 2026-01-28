<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Order::query();
        if ($status) {
            $query->where('status', $status);
        }
        $orders = $query->latest()->paginate(10);

        return view('orders.index', compact('orders', 'status'));
    }

    public function create()
    {
        $menuItems = MenuItem::where('is_available', true)->orderBy('name')->get();
        return view('orders.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_item_id' => ['required', 'integer', 'exists:menu_items,id'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        // group by menu_item_id to avoid duplicates
        $grouped = [];
        foreach ($data['items'] as $row) {
            $id = (int) $row['menu_item_id'];
            $qty = (int) $row['qty'];

            if (isset($grouped[$id])) {
                $grouped[$id] += $qty;
            } else {
                $grouped[$id] = $qty;
            }
        }

        $menuItems = MenuItem::whereIn('id', array_keys($grouped))
            ->where('is_available', true)
            ->get()
            ->keyBy('id');

        if ($menuItems->count() !== count($grouped)) {
            return back()->withErrors(['items' => 'One or more items are unavailable.'])->withInput();
        }

        $order = Order::create([
            'customer_name' => $request->input('customer_name'),
            'status' => 'pending',
            'total' => 0,
        ]);

        $total = 0;

        foreach ($grouped as $menuId => $qty) {
            $item = $menuItems[$menuId];
            $unit = (float) $item->price;
            $line = $unit * $qty;
            $total += $line;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuId,
                'qty' => $qty,
                'unit_price' => $unit,
                'line_total' => $line,
            ]);
        }

        $order->update(['total' => $total]);

        return redirect()->route('orders.show', $order)->with('success', 'Order created!');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->load('items.menuItem');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $data = $request->validate([
            'status' => ['required', 'in:pending,preparing,ready,picked_up,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('success', 'Status updated.');
    }
}
