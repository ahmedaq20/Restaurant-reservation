<?php

namespace App\Http\Controllers\Admin;

use App\Models\Table;
use App\Enums\TablesStatus;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

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
        $tables = Table::where('status',TablesStatus::AVAILABLE)->get();
        return view('admin.reservations.form', compact('reservation', 'tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($requset->all());
        $this->validateReservation($request);
         $table= Table::findOrFail($request->table_id);
        if($table->guest_number < $request->guest_number){
            return back()->with('info', 'Please choose a table according to Guest Number.');
        }
        // $reservation_date = Carbon::parse(time: $request->res_date);
        // foreach($table->reservations as $reservation_table){
        //     if($reservation_date->format('Y-m-d') ==Carbon::parse($reservation_table->res_date)->format('Y-m-d')){
        //         return back()->with('info','The table is reservied for this day?');
        //     }
        // }

         $reservationDate = Carbon::parse($request->res_date)->toDateString();

        $isReserved = $table->reservations()->whereDate('res_date', $reservationDate)->exists();

        if ($isReserved) {
            return back()->with('info', 'This table is already reserved for this day.');
        }
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
        $tables = Table::where('status',TablesStatus::AVAILABLE)->get();
        return view('admin.reservations.form', compact('reservation', 'tables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->validateReservation($request);
        $table= Table::firstOrFail($request->table_id);
        if($table->guest_number < $request->guest_number){
            return back()->with('info', 'Please choose a table according to Guest Number.');
        }
          $reservationDate = Carbon::parse($request->res_date)->toDateString();

           $isReserved = $table->reservations()
            ->whereDate('res_date', $reservationDate)
            ->where('id', '!=', $reservation->id) // لتجنب حجز نفسه وقت التعديل
            ->exists();

            if ($isReserved) {
            return back()->with('info', 'This table is already reserved for this day.');
        }
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


    public function step1(){
        $reservation = session('reservation_data', []);
    return view('front.step1', compact('reservation'));
    }

    public function postStep1(Request $request){
        $validate = $request->validate([
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
        ]);

        session(['reservation_data'=> $validate ]);
        return redirect()->route('reservation.step2');
    }

    public function step2()
    {
        $reservation = session('reservation_data'); // get all step1 data
        if (!$reservation || !isset($reservation['guest_number'])) {
            // If no session, redirect to step1
            return redirect()->route('reservation.step1')->with('info', 'Please complete step 1 first.');
        }
        
         $tables = Table::where('guest_number', '>=', $reservation['guest_number'])
        ->whereDoesntHave('reservations', function($query) use ($reservation) {
               $query->whereDate('res_date', Carbon::parse($reservation['res_date'])->toDateString());
        })->get();

        if ($tables->isEmpty()) {
        return redirect()->route('reservation.step1')
            ->with('info', 'All tables are reserved for this day. Please choose another day.');
    }

        return view('front.step2', compact('tables', 'reservation'));
    }




       public function postStep2(Request $request){
            $request->validate([
                'table_id' => 'required',
            ]);
            $finalReservationData = $request->session()->get('reservation_data');

            $finalReservationData['table_id'] = $request->table_id;
            // dd($finalReservationData);
            Reservation::create($finalReservationData);
            $request->session()->forget('reservation_data');

    return redirect()->route('welcome')->with('success', 'Your reservation was successful!');
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
            'table_id'      => 'required|exists:tables,id',
        ]);
    }
}