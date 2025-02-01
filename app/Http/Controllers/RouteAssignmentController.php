<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteAssignmentController extends Controller
{
    public function store(Request $request, Route $route)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        // End current active assignment if exists
        $route->assignments()->active()->update([
            'status' => 'inactive',
            'end_date' => now()
        ]);

        // Create new assignment
        $route->assignments()->create([
            ...$validated,
            'status' => 'active'
        ]);

        return back()->with('success', 'Route assignment created successfully.');
    }

    public function update(Request $request, RouteAssignment $assignment)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validated['status'] === 'active') {
            // Deactivate other active assignments for this route
            $assignment->route->assignments()
                ->where('id', '!=', $assignment->id)
                ->active()
                ->update(['status' => 'inactive', 'end_date' => now()]);
        }

        $assignment->update($validated);

        return back()->with('success', 'Route assignment updated successfully.');
    }

    public function destroy(RouteAssignment $assignment)
    {
        if ($assignment->status === 'active') {
            return back()->with('error', 'Cannot delete active assignment.');
        }

        $assignment->delete();

        return back()->with('success', 'Route assignment deleted successfully.');
    }

    public function endAssignment(RouteAssignment $assignment)
    {
        $assignment->update([
            'status' => 'inactive',
            'end_date' => now()
        ]);

        return back()->with('success', 'Assignment ended successfully.');
    }
} 