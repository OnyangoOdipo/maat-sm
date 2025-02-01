<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('class')
            ->where('school_id', Auth::user()->school_id)
            ->latest()
            ->paginate(10);

        // Get classes for the filter dropdown
        $classes = ClassRoom::where('school_id', auth()->user()->school_id)
            ->with('classLevel')
            ->get()
            ->map(function($class) {
                return [
                    'id' => $class->id,
                    'name' => $class->classLevel->name . ' ' . $class->stream
                ];
            });

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = auth()->user()->school->classes;
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'admission_number' => 'required|string|unique:students,admission_number',
            'class_id' => 'required|exists:classes,id',
            'roll_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'phone' => 'required|string',
            'parent_name' => 'required|string',
            'parent_phone' => 'required|string',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'), // Set a default password
            'role' => 'student',
            'school_id' => auth()->user()->school_id,
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $user->id,
            'school_id' => auth()->user()->school_id,
            'class_id' => $validated['class_id'],
            'admission_number' => $validated['admission_number'],
            'roll_number' => $validated['roll_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $this->authorize('view', $student);
        
        $student->load(['user', 'class', 'attendances', 'performances']);
        
        return view('students.show', compact('student'));
    }

    // ... other methods
} 