<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\ClassLevel;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $classData = [
                'school_id' => Auth::user()->school_id,
                'class_level_id' => $validated['class_level_id'],
                'stream' => $validated['stream'],
                'capacity' => $validated['capacity'],
                'teacher_id' => $validated['teacher_id'],
                'room_number' => $validated['room_number'],
                'status' => $validated['status'] ?? 'active'
            ];

            ClassRoom::create($classData);

            return redirect()->route('classes.index')
                ->with('success', 'Class created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating class', [
                'error' => $e->getMessage(),
                'data' => $classData ?? null
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error creating class: ' . $e->getMessage()]);
        }
    }

    public function edit(ClassRoom $class)
    {
        // Load necessary relationships
        $class->load(['classLevel.section']);
        
        $sections = Section::where('school_id', auth()->user()->school_id)->get();
        $teachers = Teacher::where('school_id', auth()->user()->school_id)
            ->with('user')
            ->get();

        // Get class levels for the current section
        $classLevels = ClassLevel::where('section_id', $class->classLevel->section_id)
            ->where('school_id', auth()->user()->school_id)
            ->get();

        return view('classes.edit', compact('class', 'sections', 'teachers', 'classLevels'));
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
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $class->update([
                'class_level_id' => $validated['class_level_id'],
                'stream' => $validated['stream'],
                'capacity' => $validated['capacity'],
                'teacher_id' => $validated['teacher_id'],
                'room_number' => $validated['room_number'],
                'status' => $validated['status']
            ]);

            return redirect()->route('classes.index')
                ->with('success', 'Class updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating class', [
                'error' => $e->getMessage(),
                'class_id' => $class->id
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error updating class: ' . $e->getMessage()]);
        }
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

    public function getClassLevels($sectionId)
    {
        try {
            $classLevels = ClassLevel::where('section_id', $sectionId)
                ->where('school_id', Auth::user()->school_id)
                ->get(['id', 'name']);

            return response()->json($classLevels);
        } catch (\Exception $e) {
            \Log::error('Error fetching class levels', [
                'error' => $e->getMessage(),
                'section_id' => $sectionId
            ]);
            return response()->json([], 500);
        }
    }
} 