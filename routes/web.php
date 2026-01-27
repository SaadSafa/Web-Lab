<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect('/orders');
});

// Menu Items Routes
Route::get('/menu-items', 'App\Http\Controllers\MenuItemController@index')->name('menu-items.index');
Route::get('/menu-items/create', 'App\Http\Controllers\MenuItemController@create')->name('menu-items.create');
Route::post('/menu-items/store', 'App\Http\Controllers\MenuItemController@store')->name('menu-items.store');
Route::get('/menu-items/{id}/edit', 'App\Http\Controllers\MenuItemController@edit')->name('menu-items.edit');
Route::post('/menu-items/{id}/update', 'App\Http\Controllers\MenuItemController@update')->name('menu-items.update');
Route::post('/menu-items/{id}/delete', 'App\Http\Controllers\MenuItemController@destroy')->name('menu-items.destroy');

// Orders Routes
Route::get('/orders', 'App\Http\Controllers\OrderController@index')->name('orders.index');
Route::get('/orders/create', 'App\Http\Controllers\OrderController@create')->name('orders.create');
Route::post('/orders/store', 'App\Http\Controllers\OrderController@store')->name('orders.store');
Route::get('/orders/{id}', 'App\Http\Controllers\OrderController@show')->name('orders.show');

// Custom Status Update Route
Route::post('/orders/{id}/status', 'App\Http\Controllers\OrderController@updateStatus')->name('orders.status');

// Queue Route
Route::get('/queue', 'App\Http\Controllers\QueueController@index')->name('queue');
