<?php

namespace App\Http\Controllers;

use App\Models\Order;

class QueueController extends Controller
{
    public function index()
    {
        $preparing = Order::where('status', 'preparing')->latest()->take(12)->get();
        $ready = Order::where('status', 'ready')->latest()->take(12)->get();

        return view('queue.index', compact('preparing', 'ready'));
    }
}