<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('roomId')->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'roomId' => 'required|string',
                'clientId' => 'required|string',
                'clientName' => 'required|string',
                'clientEmail' => 'required|string',
                'clientPhone' => 'string',
                'oderDate' => 'required|date',
                'checkInDate' => 'required|date',
                'checkOutDate' => 'required|date',
                'status' => 'required|in:Check In, Check Out, In Progress' 
            ]);

            \Log::info('Validated:', $validated);
            $room = \DB::table('room')->where('id', 1)->first();
            if (!Room::find($validated['roomId'])) {
                return back()->withErrors(['roomId' => 'Room doesn´t exists in database']);
            }
        } catch(\Throwable $err) {
            report($err);
            return back()->withErrors(['error' =>getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with('booking')->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
                'roomId' => 'required|string',
                'clientId' => 'required|string',
                'clientName' => 'required|string',
                'clientEmail' => 'required|string',
                'clientPhone' => 'string',
                'oderDate' => 'required|date',
                'checkInDate' => 'required|date',
                'checkOutDate' => 'required|date',
                'status' => 'required|in:Check In, Check Out, In Progress' 
        ]);
        \Log::info('Updating booking:', $validated);
        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted succesfully');
    }
}
