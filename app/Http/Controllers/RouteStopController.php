<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteStopController extends Controller
{
    public function store(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'morning_time' => 'required|date_format:H:i',
            'evening_time' => 'required|date_format:H:i',
            'sequence' => 'required|integer|min:1'
        ]);

        $route->stops()->create($validated);

        return back()->with('success', 'Stop added successfully.');
    }

    public function update(Request $request, RouteStop $routeStop)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'morning_time' => 'required|date_format:H:i',
            'evening_time' => 'required|date_format:H:i',
            'sequence' => 'required|integer|min:1'
        ]);

        $routeStop->update($validated);

        return back()->with('success', 'Stop updated successfully.');
    }

    public function destroy(RouteStop $routeStop)
    {
        $routeStop->delete();

        return back()->with('success', 'Stop removed successfully.');
    }

    public function reorder(Request $request, Route $route)
    {
        $request->validate([
            'stops' => 'required|array',
            'stops.*' => 'exists:route_stops,id'
        ]);

        foreach ($request->stops as $index => $stopId) {
            RouteStop::where('id', $stopId)->update(['sequence' => $index + 1]);
        }

        return response()->json(['message' => 'Stops reordered successfully']);
    }
} 