<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::where('user_id', Auth::id())->latest()->get();
        return view('menu.index', compact('menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:500',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        Menu::create([
            'user_id'      => Auth::id(),
            'name'         => $request->name,
            'category'     => $request->category,
            'price'        => $request->price,
            'description'  => $request->description,
            'availability' => $request->availability,
        ]);

        return redirect()->route('menu.index')
            ->with('toast_success', '"' . $request->name . '" added to menu successfully.');
    }

    public function edit(Menu $menu)
    {
        if ($menu->user_id !== Auth::id()) {
            abort(403);
        }
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        if ($menu->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:500',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        $menu->update($request->only('name', 'category', 'price', 'description', 'availability'));

        return redirect()->route('menu.index')
            ->with('toast_success', '"' . $menu->name . '" updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->user_id !== Auth::id()) {
            abort(403);
        }
        $name = $menu->name;
        $menu->delete();
        return redirect()->route('menu.index')
            ->with('toast_success', '"' . $name . '" removed from menu.');
    }
}
