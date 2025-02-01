<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\TimetableSlot;
use App\Models\ClassLevel;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Services\TimetableGenerator;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $timetables = Timetable::with('classLevel')
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('timetables.index', compact('timetables'));
    }

    public function create()
    {
        $classLevels = ClassLevel::where('school_id', auth()->user()->school_id)->get();
        $terms = ['Term 1', 'Term 2', 'Term 3'];
        $currentYear = date('Y');
        $academicYears = [
            ($currentYear-1) . '/' . $currentYear,
            $currentYear . '/' . ($currentYear+1),
            ($currentYear+1) . '/' . ($currentYear+2)
        ];

        return view('timetables.create', compact('classLevels', 'terms', 'academicYears'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'class_level_id' => 'required|exists:class_levels,id',
            'term' => 'required|string',
            'academic_year' => 'required|string',
            'constraints' => 'array'
        ]);

        // Create new timetable
        $timetable = Timetable::create([
            'school_id' => auth()->user()->school_id,
            'class_level_id' => $validated['class_level_id'],
            'term' => $validated['term'],
            'academic_year' => $validated['academic_year'],
            'is_active' => true
        ]);

        // Initialize timetable generator service
        $generator = new TimetableGenerator($timetable);
        
        // Generate timetable
        $slots = $generator->generate();

        return redirect()->route('timetables.show', $timetable)
            ->with('success', 'Timetable generated successfully!');
    }

    public function show(Timetable $timetable)
    {
        $timetable->load(['slots.timeslot', 'slots.subject', 'slots.teacher', 'slots.classroom']);
        
        $slots = $timetable->slots->groupBy(function($slot) {
            return $slot->timeslot->day;
        });

        return view('timetables.show', compact('timetable', 'slots'));
    }
} 