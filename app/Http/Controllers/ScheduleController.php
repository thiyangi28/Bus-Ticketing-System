<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // List all schedules
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->get();
        return view('schedules.index', compact('schedules'));
    }

    // Show create form
    public function create()
    {
        // Only active buses should be scheduled
        $buses = Bus::where('status', true)->get();
        $routes = Route::all();
        return view('schedules.create', compact('buses', 'routes'));
    }

    // Save schedule to database
    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'fare' => 'required|numeric|min:0',
            'status' => 'required|in:Scheduled,Cancelled,Completed',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')
                         ->with('success', 'Schedule created successfully.');
    }

    // Show edit form
    public function edit(Schedule $schedule)
    {
        $buses = Bus::where('status', true)->get();
        $routes = Route::all();
        return view('schedules.edit', compact('schedule', 'buses', 'routes'));
    }

    // Update schedule
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'fare' => 'required|numeric|min:0',
            'status' => 'required|in:Scheduled,Cancelled,Completed',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')
                         ->with('success', 'Schedule updated successfully.');
    }

    // Delete schedule
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
                         ->with('success', 'Schedule deleted successfully.');
    }
}
