<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('table')->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reservation = new Reservation();
        $tables = Table::all();
        return view('admin.reservations.form', compact('reservation', 'tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateReservation($request);

        Reservation::create($request->all());
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation created!');
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
    public function edit(Reservation $reservation)
    {
        $tables = Table::all();
        return view('admin.reservations.form', compact('reservation', 'tables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->validateReservation($request);

        $reservation->update($request->all());
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('deleted', 'Reservation deleted!');
    }

    protected function validateReservation(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'tel_number'    => 'required|string|max:20',
            'res_date'      => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $date = Carbon::createFromFormat('Y-m-d\TH:i', $value);
                    $now = Carbon::now()->startOfDay();
                    $max = Carbon::now()->addWeek()->endOfDay();
                    if ($date->lt($now) || $date->gt($max)) {
                        $fail('Reservation must be from today up to one week ahead.');
                    }
                    if ($date->hour < 16 || $date->hour > 23) {
                        $fail('Reservation time must be between 16:00 and 23:00.');
                    }
                }
            ],
            'guest_number'  => 'required|integer|min:1',
            'table_id'      => 'nullable|exists:tables,id',
        ]);
    }
}