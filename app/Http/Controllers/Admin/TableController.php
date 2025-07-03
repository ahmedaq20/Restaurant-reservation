<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = \App\Models\Table::all();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $table = new \App\Models\Table();
        return view('admin.tables.form', compact('table'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'guest_number' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved,occupied',
            'location' => 'nullable|string|max:255',
        ]);
        \App\Models\Table::create($data);
        return redirect()->route('admin.tables.index')->with('success', 'Table created!');
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
    public function edit(\App\Models\Table $table)
    {
        return view('admin.tables.form', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Table $table)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'guest_number' => 'required|integer|min:1',
            'status' => 'required|in:available,reserved,occupied',
            'location' => 'nullable|string|max:255',
        ]);
        $table->update($data);
        return redirect()->route('admin.tables.index')->with('updated', 'Table updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')->with('deleted', 'Table deleted!');
    }
}