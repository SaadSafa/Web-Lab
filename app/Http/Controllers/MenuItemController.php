<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $items = MenuItem::latest()->paginate(10);
        return view('menu-items.index', compact('items'));
    }

    public function create()
    {
        return view('menu-items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'price' => ['required','numeric','min:0'],
            'is_available' => ['nullable'],
        ]);

        $data['is_available'] = $request->boolean('is_available');

        MenuItem::create($data);

        return redirect()->route('menu-items.index')->with('success', 'Menu item created.');
    }

    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return view('menu-items.edit', compact('menuItem'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'price' => ['required','numeric','min:0'],
            'is_available' => ['nullable'],
        ]);

        $data['is_available'] = $request->boolean('is_available');
        
        $menuItem = MenuItem::findOrFail($id);

        $menuItem->update($data);

        return redirect()->route('menu-items.index')->with('success', 'Menu item updated.');
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();
        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted.');
    }
}