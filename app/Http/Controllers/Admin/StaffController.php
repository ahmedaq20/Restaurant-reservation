<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::latest()->paginate(10);
        return view('admin.staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staffs.form', [
            'staff' => new Staff()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'hired_at' => ['nullable', 'date'],
            'role' => ['required', Rule::in(['chef', 'waiter', 'manager', 'cleaner'])],

        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('staffs', 'public');
        }

      $staff=Staff::create($data);
    

        return redirect()->route('admin.staffs.index')->with('success', 'staff created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('admin.staffs.show',[
            'staff' =>$staff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('admin.staffs.form', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
           'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'hired_at' => ['nullable', 'date'],
            'role' => ['required', Rule::in(['chef', 'waiter', 'manager', 'cleaner'])],
        ]);

        if ($request->hasFile('image')) {
            if($staff->image && Storage::disk('public')->exists($staff->image)){ 
                Storage::disk('public')->delete($staff->image);
            }
            $data['image'] = $request->file('image')->store('staffs', 'public');
        }

        $staff->update($data);
        
        return redirect()->route('admin.staffs.index')->with('updated', 'staff updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
       
        if($staff->image && Storage::disk('public')->exists($staff->image)){ 
                Storage::disk('public')->delete($staff->image);
        }

        $staff->delete();
        return redirect()->route('admin.staffs.index')->with('deleted', 'staff deleted!');
    }
}