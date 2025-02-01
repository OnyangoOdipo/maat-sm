<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('school_id', Auth::user()->school_id)
            ->latest()
            ->paginate(10);

        return view('transport.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('transport.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers',
            'phone' => 'required|string|max:255',
            'license_expiry' => 'required|date|after:today',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        $driver = Driver::create([
            'school_id' => Auth::user()->school_id,
            ...$validated
        ]);

        return redirect()->route('transport.drivers.index')
            ->with('success', 'Driver added successfully.');
    }

    public function show(Driver $driver)
    {
        return view('transport.drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('transport.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers,license_number,' . $driver->id,
            'phone' => 'required|string|max:255',
            'license_expiry' => 'required|date|after:today',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        $driver->update($validated);

        return redirect()->route('transport.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->routeAssignments()->exists()) {
            return back()->with('error', 'Cannot delete driver with active route assignments.');
        }

        $driver->delete();

        return redirect()->route('transport.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }
} 