<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::where('school_id', Auth::user()->school_id)->get();
        return view('boarding.houses.index', compact('houses'));
    }

    public function create()
    {
        return view('boarding.houses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:boys,girls,mixed',
            'description' => 'nullable|string',
            'total_capacity' => 'required|integer|min:1',
            'house_parent_id' => 'nullable|exists:users,id'
        ]);

        $validated['school_id'] = Auth::user()->school_id;
        $validated['is_active'] = true;

        House::create($validated);

        return redirect()->route('boarding.houses.index')
            ->with('success', 'House created successfully.');
    }

    public function show(House $house)
    {
        $house->load(['cubicles.beds.currentAssignment.student']);
        return view('boarding.houses.show', compact('house'));
    }

    public function edit(House $house)
    {
        return view('boarding.houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:boys,girls,mixed',
            'description' => 'nullable|string',
            'total_capacity' => 'required|integer|min:1',
            'house_parent_id' => 'nullable|exists:users,id'
        ]);

        $house->update($validated);

        return redirect()->route('boarding.houses.index')
            ->with('success', 'House updated successfully.');
    }

    public function destroy(House $house)
    {
        $house->delete();
        return redirect()->route('boarding.houses.index')
            ->with('success', 'House deleted successfully.');
    }
} 