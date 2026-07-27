<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // List bookings
    public function index()
    {
        $bookings = Booking::with(['user', 'schedule.bus', 'schedule.route'])->get();
        return view('bookings.index', compact('bookings'));
    }

    // Show create booking form
    public function create()
    {
        $users = User::all();
        // Only active/Scheduled schedules can be booked
        $schedules = Schedule::with(['bus', 'route'])->where('status', 'Scheduled')->get();
        return view('bookings.create', compact('users', 'schedules'));
    }

    // Store booking
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'seat_number' => 'required|integer|min:1',
            'status' => 'required|in:Booked,Cancelled,Available',
            'payment_status' => 'required|in:Paid,Unpaid,Refunded',
        ]);

        $schedule = Schedule::with('bus')->findOrFail($request->schedule_id);

        // 1. Check if seat number exceeds bus capacity
        if ($request->seat_number > $schedule->bus->capacity) {
            return back()->withErrors([
                'seat_number' => "Seat number exceeds the bus's maximum capacity of {$schedule->bus->capacity} seats."
            ])->withInput();
        }

        // 2. Check if the seat is already booked for this schedule (excluding Cancelled bookings)
        $isBooked = Booking::where('schedule_id', $request->schedule_id)
            ->where('seat_number', $request->seat_number)
            ->where('status', 'Booked')
            ->exists();

        if ($isBooked) {
            return back()->withErrors([
                'seat_number' => "Seat number {$request->seat_number} is already booked for this schedule."
            ])->withInput();
        }

        // Save booking and set total fare from schedule fare
        $bookingData = $request->all();
        $bookingData['total_fare'] = $schedule->fare;

        Booking::create($bookingData);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking created successfully.');
    }

    // Show edit booking form
    public function edit(Booking $booking)
    {
        $users = User::all();
        $schedules = Schedule::with(['bus', 'route'])->get();
        return view('bookings.edit', compact('booking', 'users', 'schedules'));
    }

    // Update booking
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'seat_number' => 'required|integer|min:1',
            'status' => 'required|in:Booked,Cancelled,Available',
            'payment_status' => 'required|in:Paid,Unpaid,Refunded',
        ]);

        $schedule = Schedule::with('bus')->findOrFail($request->schedule_id);

        // 1. Check capacity
        if ($request->seat_number > $schedule->bus->capacity) {
            return back()->withErrors([
                'seat_number' => "Seat number exceeds the bus's maximum capacity of {$schedule->bus->capacity} seats."
            ])->withInput();
        }

        // 2. Check duplicates (exclude current booking ID)
        $isBooked = Booking::where('schedule_id', $request->schedule_id)
            ->where('seat_number', $request->seat_number)
            ->where('status', 'Booked')
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($isBooked) {
            return back()->withErrors([
                'seat_number' => "Seat number {$request->seat_number} is already booked for this schedule."
            ])->withInput();
        }

        $bookingData = $request->all();
        $bookingData['total_fare'] = $schedule->fare;

        $booking->update($bookingData);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking updated successfully.');
    }

    // Cancel / Delete booking
    public function destroy(Booking $booking)
    {
        // We can either delete it or set status to Cancelled. Let's delete it for normal CRUD destroy.
        $booking->delete();

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking deleted successfully.');
    }
}
