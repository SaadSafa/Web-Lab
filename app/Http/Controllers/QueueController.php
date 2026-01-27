<?php

namespace App\Http\Controllers;

use App\Models\Order;

class QueueController extends Controller
{
    public function index()
    {
        $objPrep = new Order();
        $objPrep = Order::where('status', 'preparing')->get();
        
        $objReady = new Order();
        $objReady = Order::where('status', 'ready')->get();

        return view('queue.index', [
            'recordPrep' => $objPrep, 
            'recordReady' => $objReady
        ]);
    }
}