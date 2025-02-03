<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Student;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function show(Bed $bed)
    {
        $bed->load(['currentAssignment.student', 'cubicle.house']);
        return view('boarding.beds.show', compact('bed'));
    }

    public function edit(Bed $bed)
    {
        $bed->load('cubicle.house');
        return view('boarding.beds.edit', compact('bed'));
    }

    public function update(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'needs_maintenance' => 'required|boolean',
            'maintenance_notes' => 'nullable|string|max:255',
        ]);

        $bed->update($validated);

        return redirect()->route('boarding.cubicles.show', $bed->cubicle_id)
            ->with('success', 'Bed updated successfully.');
    }

    public function assignStudent(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // End any current assignment
        if ($bed->currentAssignment) {
            $bed->currentAssignment->update(['end_date' => now()]);
        }

        // Create new assignment
        $bed->assignments()->create([
            'student_id' => $validated['student_id'],
            'assigned_date' => $validated['assigned_date'],
            'notes' => $validated['notes'],
        ]);

        $bed->update(['is_occupied' => true]);

        return redirect()->route('boarding.cubicles.show', $bed->cubicle_id)
            ->with('success', 'Student assigned successfully.');
    }

    public function unassignStudent(Bed $bed)
    {
        if ($bed->currentAssignment) {
            $bed->currentAssignment->update(['end_date' => now()]);
            $bed->update(['is_occupied' => false]);
        }

        return redirect()->route('boarding.cubicles.show', $bed->cubicle_id)
            ->with('success', 'Student unassigned successfully.');
    }
} 