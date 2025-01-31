<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\ClassLevel;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $sections = Section::where('school_id', auth()->user()->school_id)
            ->with(['classLevels.classRooms' => function($query) {
                $query->withCount('students');
            }])
            ->get();

        $teachers = Teacher::where('school_id', auth()->user()->school_id)
            ->with('user')
            ->get();

        return view('classes.index', compact('sections', 'teachers'));
    }

    public function create()
    {
        $sections = Section::where('school_id', auth()->user()->school_id)->get();
        $teachers = Teacher::where('school_id', auth()->user()->school_id)
            ->with('user')
            ->get();

        return view('classes.create', compact('sections', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'stream' => 'required|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'room_number' => 'nullable|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['status'] = 'active';

        ClassRoom::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit(ClassRoom $class)
    {
        $sections = Section::where('school_id', auth()->user()->school_id)->get();
        $teachers = Teacher::where('school_id', auth()->user()->school_id)
            ->with('user')
            ->get();

        return view('classes.edit', compact('class', 'sections', 'teachers'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'stream' => 'required|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'room_number' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassRoom $class)
    {
        // Check if class has students
        if ($class->students()->count() > 0) {
            return back()->with('error', 'Cannot delete class with students.');
        }

        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }
} 