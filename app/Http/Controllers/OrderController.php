<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::query()
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

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
            $grouped[$id] = ($grouped[$id] ?? 0) + $qty;
        }

        $menuItems = MenuItem::whereIn('id', array_keys($grouped))
            ->where('is_available', true)
            ->get()
            ->keyBy('id');

        if ($menuItems->count() !== count($grouped)) {
            return back()->withErrors(['items' => 'One or more items are unavailable.'])->withInput();
        }

        return DB::transaction(function () use ($request, $menuItems, $grouped) {

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
        });
    }

    public function show(Order $order)
    {
        $order->load('items.menuItem');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,preparing,ready,picked_up,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status updated.');
    }
}