<?php

namespace App\Http\Controllers;

use App\Models\BedAssignment;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BedAssignmentController extends Controller
{
    public function index()
    {
        $houses = House::with(['cubicles.beds.currentAssignment.student'])
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return view('boarding.assignments.index', compact('houses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'student_id' => 'required|exists:students,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        BedAssignment::create($validated);

        return redirect()->back()->with('success', 'Assignment created successfully.');
    }

    public function update(Request $request, BedAssignment $assignment)
    {
        $validated = $request->validate([
            'end_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $assignment->update($validated);

        return redirect()->back()->with('success', 'Assignment updated successfully.');
    }
} 