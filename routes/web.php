<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QueueController;
use App\Models\Order;

Route::get('/', function() {
    return redirect('/orders');
});

Route::get('/menu-items', [MenuItemController::class, 'index'])->name('menu-items.index');
Route::get('/menu-items/create', [MenuItemController::class, 'create'])->name('menu-items.create');
Route::post('/menu-items/store', [MenuItemController::class, 'store'])->name('menu-items.store');
Route::get('/menu-items/{id}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
Route::post('/menu-items/{id}/update', [MenuItemController::class, 'update'])->name('menu-items.update');
Route::post('/menu-items/{id}/delete', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');


Route::get('/queue', [QueueController::class, 'index'])->name('queue');
