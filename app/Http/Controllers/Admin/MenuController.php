<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.form', ['menu' => new Menu()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.form', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('updated', 'Menu updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('deleted', 'Menu deleted!');
    }
}