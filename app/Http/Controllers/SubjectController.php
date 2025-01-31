<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\CurriculumType;
use App\Models\ClassLevel;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('school_id', 1) // Temporarily hardcoded
            ->with(['curriculumTypes', 'classLevels', 'classRooms', 'teachers'])
            ->latest()
            ->paginate(10);

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $curriculumTypes = CurriculumType::where('school_id', 1)->get();
        $classLevels = ClassLevel::where('school_id', 1)->get();
        $classRooms = ClassRoom::where('school_id', 1)->get();
        $teachers = Teacher::where('school_id', 1)->get();

        return view('subjects.create', compact('curriculumTypes', 'classLevels', 'classRooms', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_type' => 'required|in:core,elective,optional',
            'curriculum_types' => 'required|array',
            'curriculum_types.*' => 'exists:curriculum_types,id',
            'class_levels' => 'required|array',
            'class_levels.*' => 'exists:class_levels,id',
            'class_rooms' => 'nullable|array',
            'class_rooms.*' => 'exists:class_rooms,id',
            'teachers' => 'required|array',
            'teachers.*' => 'exists:teachers,id',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Generate subject code
            $code = Str::upper(Str::substr($validated['name'], 0, 3)) . 
                   str_pad(Subject::count() + 1, 3, '0', STR_PAD_LEFT);

            // Create subject
            $subject = Subject::create([
                'name' => $validated['name'],
                'code' => $code,
                'school_id' => 1, // Temporarily hardcoded
                'description' => $validated['description'],
                'subject_type' => $validated['subject_type'],
                'status' => 'active',
                'notes' => $validated['notes']
            ]);

            // Attach curriculum types
            $subject->curriculumTypes()->attach($validated['curriculum_types'], [
                'is_compulsory' => $request->input('curriculum_compulsory', true)
            ]);

            // Attach class levels
            $subject->classLevels()->attach($validated['class_levels'], [
                'is_compulsory' => $request->input('class_level_compulsory', true)
            ]);

            // Attach classrooms if specified
            if (!empty($validated['class_rooms'])) {
                foreach ($validated['class_rooms'] as $classRoomId) {
                    $subject->classRooms()->attach($classRoomId, [
                        'teacher_id' => $request->input("teacher_id.{$classRoomId}"),
                        'is_compulsory' => $request->input("classroom_compulsory.{$classRoomId}", true)
                    ]);
                }
            }

            // Attach teachers
            $subject->teachers()->attach($validated['teachers']);
        });

        return redirect()->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    // ... more methods to follow
} 