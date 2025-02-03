<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::where('school_id', Auth::user()->school_id)
            ->with(['stops', 'assignments.driver', 'assignments.vehicle'])
            ->latest()
            ->paginate(10);

        return view('transport.routes.index', compact('routes'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('school_id', Auth::user()->school_id)
            ->where('status', 'active')
            ->get();
            
        $drivers = Driver::where('school_id', Auth::user()->school_id)
            ->where('status', 'active')
            ->get();

        return view('transport.routes.create', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'morning_pickup_time' => 'required|date_format:H:i',
            'evening_departure_time' => 'required|date_format:H:i',
            'fee_amount' => 'required|numeric|min:0',
            'stops' => 'required|array|min:1',
            'stops.*.name' => 'required|string|max:255',
            'stops.*.morning_time' => 'required|date_format:H:i',
            'stops.*.evening_time' => 'required|date_format:H:i',
            'stops.*.sequence' => 'required|integer|min:1',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id'
        ]);

        $route = Route::create([
            'school_id' => Auth::user()->school_id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'morning_pickup_time' => $validated['morning_pickup_time'],
            'evening_departure_time' => $validated['evening_departure_time'],
            'fee_amount' => $validated['fee_amount'],
            'is_active' => true
        ]);

        // Create stops with explicit sequence ordering
        collect($validated['stops'])
            ->sortBy('sequence')
            ->each(function ($stop, $index) use ($route) {
                $route->stops()->create([
                    'name' => $stop['name'],
                    'morning_time' => $stop['morning_time'],
                    'evening_time' => $stop['evening_time'],
                    'sequence' => $index + 1
                ]);
            });

        // Create route assignment
        $route->assignments()->create([
            'vehicle_id' => $validated['vehicle_id'],
            'driver_id' => $validated['driver_id'],
            'status' => 'active',
            'start_date' => now()
        ]);

        return redirect()->route('transport.routes.index')
            ->with('success', 'Route created successfully.');
    }

    public function show(Route $route)
    {
        $route->load(['stops', 'assignments.driver', 'assignments.vehicle']);
        return view('transport.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        $vehicles = Vehicle::where('school_id', Auth::user()->school_id)
            ->where('status', 'active')
            ->get();
            
        $drivers = Driver::where('school_id', Auth::user()->school_id)
            ->where('status', 'active')
            ->get();

        $route->load(['stops', 'assignments.driver', 'assignments.vehicle']);
        
        return view('transport.routes.edit', compact('route', 'vehicles', 'drivers'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'morning_pickup_time' => 'required|date_format:H:i',
            'evening_departure_time' => 'required|date_format:H:i',
            'fee_amount' => 'required|numeric|min:0',
            'stops' => 'required|array|min:1',
            'stops.*.name' => 'required|string|max:255',
            'stops.*.morning_time' => 'required|date_format:H:i',
            'stops.*.evening_time' => 'required|date_format:H:i',
            'stops.*.sequence' => 'required|integer|min:1',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id'
        ]);

        $route->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'morning_pickup_time' => $validated['morning_pickup_time'],
            'evening_departure_time' => $validated['evening_departure_time'],
            'fee_amount' => $validated['fee_amount']
        ]);

        // Update stops
        $route->stops()->delete();
        foreach ($validated['stops'] as $stop) {
            $route->stops()->create($stop);
        }

        // Update current assignment
        $currentAssignment = $route->assignments()->active()->first();
        if ($currentAssignment) {
            if ($currentAssignment->vehicle_id != $validated['vehicle_id'] || 
                $currentAssignment->driver_id != $validated['driver_id']) {
                // End current assignment
                $currentAssignment->update([
                    'status' => 'inactive',
                    'end_date' => now()
                ]);
                
                // Create new assignment
                $route->assignments()->create([
                    'vehicle_id' => $validated['vehicle_id'],
                    'driver_id' => $validated['driver_id'],
                    'status' => 'active',
                    'start_date' => now()
                ]);
            }
        }

        return redirect()->route('transport.routes.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->stops()->delete();
        $route->assignments()->delete();
        $route->delete();

        return redirect()->route('transport.routes.index')
            ->with('success', 'Route deleted successfully.');
    }
} 