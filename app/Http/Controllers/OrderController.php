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
        $status = request('status');
        $objOrder = new Order();

        if ($status) {
            $objOrder = Order::where('status', $status)->get();
        } else {
            $objOrder = Order::all();
        }

        return view('orders.index', ['record' => $objOrder, 'status' => $status]);
    }

    public function create()
    {
        $objMenu = new MenuItem();
        $objMenu = MenuItem::where('is_available', true)->get();
        return view('orders.create', ['record' => $objMenu]);
    }

    public function store(Request $request)
    {
        $items = request('items');
        
        $grouped = [];
        foreach ($items as $row) {
            $id = (int) $row['menu_item_id'];
            $qty = (int) $row['qty'];
            $grouped[$id] = ($grouped[$id] ?? 0) + $qty;
        }

        $menuItems = MenuItem::whereIn('id', array_keys($grouped))
            ->where('is_available', true)
            ->get()
            ->keyBy('id');

        return DB::transaction(function () use ($request, $menuItems, $grouped) {
            $objOrder = new Order();
            $objOrder->customer_name = request('customer_name');
            $objOrder->status = 'pending';
            $objOrder->total = 0;
            $objOrder->save();

            $total = 0;

            foreach ($grouped as $menuId => $qty) {
                $item = $menuItems[$menuId];
                $unit = (float) $item->price;
                $line = $unit * $qty;
                $total += $line;

                $objOrderItem = new OrderItem();
                $objOrderItem->order_id = $objOrder->id;
                $objOrderItem->menu_item_id = $menuId;
                $objOrderItem->qty = $qty;
                $objOrderItem->unit_price = $unit;
                $objOrderItem->line_total = $line;
                $objOrderItem->save();
            }

            $objOrder->total = $total;
            $objOrder->save();

            return redirect('/orders/' . $objOrder->id);
        });
    }

    public function show($id)
    {
        $objOrder = new Order();
        $objOrder = Order::find($id);
        $objOrder->load('items.menuItem');
        return view('orders.show', ['rec' => $objOrder]);
    }

    public function updateStatus(Request $request, $id)
    {
        $objOrder = new Order();
        $objOrder = Order::find($id);
        $objOrder->status = request('status');
        $objOrder->save();

        return redirect()->back();
    }
}