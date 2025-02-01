<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('school_id', auth()->user()->school_id)
            ->latest()
            ->paginate(10);

        return view('transport.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('transport.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|unique:vehicles',
            'model' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
            'notes' => 'nullable|string'
        ]);

        $vehicle = Vehicle::create([
            'school_id' => auth()->user()->school_id,
            ...$validated
        ]);

        return redirect()->route('transport.vehicles.index')
            ->with('success', 'Vehicle added successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('transport.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('transport.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|unique:vehicles,registration_number,' . $vehicle->id,
            'model' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
            'notes' => 'nullable|string'
        ]);

        $vehicle->update($validated);

        return redirect()->route('transport.vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('transport.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }
} 