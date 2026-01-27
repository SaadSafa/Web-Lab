<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $objItem = new MenuItem();
        $objItem = MenuItem::all();
        return view('menu-items.index', ['record' => $objItem]);
    }

    public function create()
    {
        return view('menu-items.create');
    }

    public function store(Request $request)
    {
        $objItem = new MenuItem();
        $objItem->name = request('name');
        $objItem->price = request('price');
        $objItem->is_available = request('is_available') ? 1 : 0;
        $objItem->save();

        return redirect('/menu-items');
    }

    public function edit($id)
    {
        $objItem = new MenuItem();
        $objItem = MenuItem::find($id);
        return view('menu-items.edit', ['rec' => $objItem]);
    }

    public function update(Request $request, $id)
    {
        $objItem = new MenuItem();
        $objItem = MenuItem::find($id);
        $objItem->name = request('name');
        $objItem->price = request('price');
        $objItem->is_available = request('is_available') ? 1 : 0;
        $objItem->save();

        return redirect('/menu-items');
    }

    public function destroy($id)
    {
        $objItem = new MenuItem();
        $objItem = MenuItem::find($id);
        $objItem->delete();
        return redirect('/menu-items');
    }
}