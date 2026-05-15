<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
   //get all buses
    public function index()
    {
        $buses = Bus::all();
        return view('buses.index', compact('buses'));

    }

    //insert
    public function create()
    {
        return view('buses.create');
    }

    // save to db
    public function store(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses',
            'model' => 'required',
            'capacity' => 'required|integer',
            'type' => 'required|in:AC,Non-AC,Luxury',
           
        ]);

        Bus::create($request->all());

        return redirect()->route('buses.index')
                         ->with('success', 'Bus created successfully.');
    }



   //update
    public function edit(Bus $bus)
    {
    
       return view('buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses,bus_number,' . $bus->id,
            'model' => 'required',
            'capacity' => 'required|integer',
            'type' => 'required|in:AC,Non-AC,Luxury',
        ]);

        $bus->update($request->all());

        return redirect()->route('buses.index')
                         ->with('success', 'Bus updated successfully.');
      
    }

   //delete
    public function destroy(Bus $bus)
    {
        $bus->delete();

        return redirect()->route('buses.index')
                         ->with('success', 'Bus deleted successfully.');
    }
}
