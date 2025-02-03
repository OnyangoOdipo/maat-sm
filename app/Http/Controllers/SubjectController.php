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
        $subjects = Subject::where('school_id', auth()->user()->school_id)
            ->with(['teachers', 'classLevels'])
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

    public function show(Subject $subject)
    {
        // Check if user has permission to view this subject
        if (auth()->user()->school_id !== $subject->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $subject->load([
            'curriculumTypes',
            'classLevels',
            'teachers.user',
        ]);

        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        // Check if user has permission to edit this subject
        if (auth()->user()->school_id !== $subject->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $curriculumTypes = CurriculumType::where('school_id', auth()->user()->school_id)->get();
        $classLevels = ClassLevel::where('school_id', auth()->user()->school_id)->get();
        $teachers = Teacher::where('school_id', auth()->user()->school_id)
            ->with('user')
            ->get();

        return view('subjects.edit', compact('subject', 'curriculumTypes', 'classLevels', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        // Check if user has permission to update this subject
        if (auth()->user()->school_id !== $subject->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_type' => 'required|in:core,elective,optional',
            'curriculum_types' => 'required|array',
            'curriculum_types.*' => 'exists:curriculum_types,id',
            'class_levels' => 'required|array',
            'class_levels.*' => 'exists:class_levels,id',
            'teachers' => 'required|array',
            'teachers.*' => 'exists:teachers,id',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            DB::transaction(function () use ($validated, $subject, $request) {
                $subject->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'subject_type' => $validated['subject_type'],
                    'status' => $validated['status']
                ]);

                // Sync relationships
                $subject->curriculumTypes()->sync($validated['curriculum_types']);
                $subject->classLevels()->sync($validated['class_levels']);
                $subject->teachers()->sync($validated['teachers']);
            });

            return redirect()->route('subjects.index')
                ->with('success', 'Subject updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating subject', [
                'error' => $e->getMessage(),
                'subject_id' => $subject->id
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error updating subject: ' . $e->getMessage()]);
        }
    }

    public function destroy(Subject $subject)
    {
        // Check if user has permission to delete this subject
        if (auth()->user()->school_id !== $subject->school_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::transaction(function () use ($subject) {
                // Detach all relationships
                $subject->curriculumTypes()->detach();
                $subject->classLevels()->detach();
                $subject->teachers()->detach();

                // Delete the subject
                $subject->delete();
            });

            return redirect()->route('subjects.index')
                ->with('success', 'Subject deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting subject', [
                'error' => $e->getMessage(),
                'subject_id' => $subject->id
            ]);

            return back()->withErrors(['error' => 'Error deleting subject: ' . $e->getMessage()]);
        }
    }
} 