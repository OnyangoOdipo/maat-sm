<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::where('school_id', 1) // Temporarily hardcoded
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'phone' => 'required|string',
            'qualification' => 'required|string',
            'specialization' => 'required|string',
            'joining_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated) {
            // Generate employee number
            $latestTeacher = Teacher::where('school_id', 1)
                ->orderBy('id', 'desc')
                ->first();
            
            $employeeNumber = 'T' . str_pad(
                $latestTeacher ? (intval(substr($latestTeacher->employee_number, 1)) + 1) : 1, 
                4, 
                '0', 
                STR_PAD_LEFT
            );

            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'), // Default password
                'role' => 'teacher',
                'school_id' => 1, // Temporarily hardcoded
            ]);

            // Create teacher record
            Teacher::create([
                'user_id' => $user->id,
                'school_id' => 1, // Temporarily hardcoded
                'employee_number' => $employeeNumber,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'qualification' => $validated['qualification'],
                'specialization' => $validated['specialization'],
                'joining_date' => $validated['joining_date'],
                'status' => 'active',
                'notes' => $validated['notes']
            ]);
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'required|string|max:255',
            'subjects' => 'required|array|exists:subjects,id',
        ]);

        $teacher->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        $teacher->subjects()->sync($validated['subjects']);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $this->authorize('delete', $teacher);

        // Check if teacher has assigned classes
        if ($teacher->classRooms()->count() > 0) {
            return back()->with('error', 'Cannot delete teacher with assigned classes.');
        }

        DB::transaction(function () use ($teacher) {
            $teacher->user->delete();
            $teacher->delete();
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
