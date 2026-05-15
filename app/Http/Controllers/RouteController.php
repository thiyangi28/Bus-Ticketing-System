<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
   //get all routes
    public function index()
    {
        $routes = Route::all();
        return view('routes.index', compact('routes'));
    }

    //insert
    public function create()
    {
       return view('routes.create');
    }

    //save db
    public function store(Request $request)
    {
       $request->validate([
            'route_number' => 'required|unique:routes',
            'start_point' => 'required',
            'end_point' => 'required',
            'distance' => 'nullable|integer',
            'duration' => 'nullable|string',
        ]);

        Route::create($request->all());

        return redirect()->route('routes.index')
                         ->with('success', 'Route created successfully.');
    }


    //edit
    public function edit(Route $route)
    {
       
        return view('routes.edit', compact('route'));   
    }

   
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'route_number' => 'required|unique:routes,route_number,' . $route->id,
            'start_point' => 'required',
            'end_point' => 'required',
            'distance' => 'nullable|integer',
            'duration' => 'nullable|string',
        ]);

        $route->update($request->all());

        return redirect()->route('routes.index')
                         ->with('success', 'Route updated successfully.');
    }

    //delete
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('routes.index')
                         ->with('success', 'Route deleted successfully.');  
    }
}
