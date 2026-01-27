<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QueueController;

Route::get('/', fn() => redirect()->route('orders.index'));


Route::resource('menu-items', MenuItemController::class);
Route::resource('orders', OrderController::class)->only(['index','create','store','show']);


Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');


Route::get('/queue', [QueueController::class, 'index'])->name('queue');
