<?php

namespace App\Http\Controllers;

use App\Models\Cubicle;
use App\Models\House;
use Illuminate\Http\Request;

class CubicleController extends Controller
{
    public function create(Request $request)
    {
        $house = House::findOrFail($request->query('house'));
        return view('boarding.cubicles.create', compact('house'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:standard,prefect,special_needs,isolation',
            'floor_number' => 'required|integer|min:1',
        ]);

        $validated['is_active'] = true;

        $cubicle = Cubicle::create($validated);

        // Create the specified number of beds for this cubicle
        for ($i = 1; $i <= $validated['capacity']; $i++) {
            $cubicle->beds()->create([
                'bed_number' => $i,
                'is_occupied' => false,
                'needs_maintenance' => false,
            ]);
        }

        return redirect()->route('boarding.houses.show', $request->house_id)
            ->with('success', 'Cubicle created successfully.');
    }

    public function show(Cubicle $cubicle)
    {
        $cubicle->load(['beds.currentAssignment.student']);
        return view('boarding.cubicles.show', compact('cubicle'));
    }

    public function edit(Cubicle $cubicle)
    {
        return view('boarding.cubicles.edit', compact('cubicle'));
    }

    public function update(Request $request, Cubicle $cubicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,prefect,special_needs,isolation',
            'floor_number' => 'required|integer|min:1',
            'maintenance_notes' => 'nullable|string',
        ]);

        $cubicle->update($validated);

        return redirect()->route('boarding.houses.show', $cubicle->house_id)
            ->with('success', 'Cubicle updated successfully.');
    }
} 