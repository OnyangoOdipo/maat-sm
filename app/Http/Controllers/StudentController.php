<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('class')
            ->where('school_id', Auth::user()->school_id)
            ->latest()
            ->paginate(10);

        // Get classes for the filter dropdown
        $classes = ClassRoom::where('school_id', Auth::user()->school_id)
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
        try {
            \Log::info('Create method called');
            
            // Check if user has a school
            if (!Auth::user() || !Auth::user()->school) {
                \Log::warning('User has no school', ['user_id' => Auth::id()]);
                return redirect()->route('students.index')
                    ->with('error', 'School information not found. Please contact administrator.');
            }

            $classes = ClassRoom::where('school_id', Auth::user()->school_id)
                ->with('classLevel')
                ->get();
            
            \Log::info('Classes retrieved', ['count' => $classes->count()]);

            return view('students.create', compact('classes'));
        } catch (\Exception $e) {
            \Log::error('Error in create method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('students.index')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function store(Request $request)
    {
        \Log::info('Store method called', ['request' => $request->all()]);

        // Check if user has a school
        if (!Auth::user() || !Auth::user()->school_id) {
            \Log::warning('No school found for user', ['user_id' => Auth::id()]);
            return redirect()->route('students.index')
                ->with('error', 'School information not found. Please contact administrator.');
        }

        try {
            // Generate admission number (Format: YEAR/SERIAL e.g., 2025/001)
            $latestStudent = Student::where('school_id', Auth::user()->school_id)
                ->whereYear('created_at', now()->year)
                ->latest()
                ->first();

            $serialNumber = $latestStudent ? 
                (int)substr($latestStudent->admission_number, -3) + 1 : 
                1;
            
            $admissionNumber = sprintf('%d/%03d', now()->year, $serialNumber);

            // Generate roll number (Format: CLASS-SERIAL e.g., 1A-001)
            $classRoom = ClassRoom::find($request->classroom_id);
            $latestClassStudent = Student::where('classroom_id', $request->classroom_id)
                ->latest()
                ->first();

            $classSerialNumber = $latestClassStudent ? 
                (int)substr($latestClassStudent->roll_number, -3) + 1 : 
                1;
            
            $rollNumber = sprintf('%s-%03d', 
                $classRoom->classLevel->name . $classRoom->stream, 
                $classSerialNumber
            );

            $validated = $request->validate([
                // User table fields
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',

                // Student table fields
                'classroom_id' => 'required|exists:classrooms,id',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'address' => 'required|string',
                'phone' => 'nullable|string',
                
                // Parent information
                'parent_name' => 'required|string',
                'parent_phone' => 'required|string',
                'parent_email' => 'nullable|email',
                'parent_occupation' => 'nullable|string',
                'parent_relationship' => 'required|in:father,mother,guardian',
                
                // Emergency contact
                'emergency_contact_name' => 'nullable|string',
                'emergency_contact_phone' => 'nullable|string',
                'emergency_contact_relationship' => 'nullable|string',
                
                // Medical information
                'medical_conditions' => 'nullable|string',
                'allergies' => 'nullable|string',
                'blood_group' => 'nullable|string',
                
                // Additional information
                'admission_date' => 'required|date',
                'status' => 'required|in:active,inactive,graduated,transferred',
                'previous_school' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            \Log::info('Validation passed', ['validated' => $validated]);

            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt(Str::random(12)), // Generate a random password
                'role' => 'student',
                'school_id' => Auth::user()->school_id,
            ]);

            \Log::info('User created', ['user_id' => $user->id]);

            // Create student record with auto-generated numbers
            $student = Student::create([
                'user_id' => $user->id,
                'school_id' => Auth::user()->school_id,
                'classroom_id' => $validated['classroom_id'],
                'admission_number' => $admissionNumber, // Auto-generated
                'roll_number' => $rollNumber, // Auto-generated
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'parent_name' => $validated['parent_name'],
                'parent_phone' => $validated['parent_phone'],
                'parent_email' => $validated['parent_email'],
                'parent_occupation' => $validated['parent_occupation'],
                'parent_relationship' => $validated['parent_relationship'],
                'emergency_contact_name' => $validated['emergency_contact_name'],
                'emergency_contact_phone' => $validated['emergency_contact_phone'],
                'emergency_contact_relationship' => $validated['emergency_contact_relationship'],
                'medical_conditions' => $validated['medical_conditions'],
                'allergies' => $validated['allergies'],
                'blood_group' => $validated['blood_group'],
                'admission_date' => $validated['admission_date'],
                'status' => $validated['status'],
                'previous_school' => $validated['previous_school'],
                'notes' => $validated['notes'],
            ]);

            \Log::info('Student created', [
                'student_id' => $student->id,
                'admission_number' => $admissionNumber,
                'roll_number' => $rollNumber
            ]);

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating student', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error creating student: ' . $e->getMessage()]);
        }
    }

    public function show(Student $student)
    {
        // Check if user has permission to view this student
        if (Auth::user()->school_id !== $student->school_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load all necessary relationships with error handling
        $student->load([
            'user',
            'class.classLevel' // Eager load both class and its classLevel
        ]);
        
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        // Check if user has permission to edit this student
        if (Auth::user()->school_id !== $student->school_id) {
            abort(403, 'Unauthorized action.');
        }

        // Load the student with necessary relationships
        $student->load(['user', 'class.classLevel']);

        // Get classes for the dropdown
        $classes = ClassRoom::where('school_id', Auth::user()->school_id)
            ->with('classLevel')
            ->get();

        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        // Check if user has permission to update this student
        if (Auth::user()->school_id !== $student->school_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $validated = $request->validate([
                // User table fields
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $student->user_id,

                // Student table fields
                'classroom_id' => 'required|exists:classrooms,id',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'address' => 'required|string',
                'phone' => 'nullable|string',
                
                // Parent information
                'parent_name' => 'required|string',
                'parent_phone' => 'required|string',
                'parent_email' => 'nullable|email',
                'parent_occupation' => 'nullable|string',
                'parent_relationship' => 'required|in:father,mother,guardian',
                
                // Emergency contact
                'emergency_contact_name' => 'nullable|string',
                'emergency_contact_phone' => 'nullable|string',
                'emergency_contact_relationship' => 'nullable|string',
                
                // Medical information
                'medical_conditions' => 'nullable|string',
                'allergies' => 'nullable|string',
                'blood_group' => 'nullable|string',
                
                // Additional information
                'admission_date' => 'required|date',
                'status' => 'required|in:active,inactive,graduated,transferred',
                'previous_school' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            DB::beginTransaction();

            // Update user information
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update student information
            $student->update([
                'classroom_id' => $validated['classroom_id'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'parent_name' => $validated['parent_name'],
                'parent_phone' => $validated['parent_phone'],
                'parent_email' => $validated['parent_email'],
                'parent_occupation' => $validated['parent_occupation'],
                'parent_relationship' => $validated['parent_relationship'],
                'emergency_contact_name' => $validated['emergency_contact_name'],
                'emergency_contact_phone' => $validated['emergency_contact_phone'],
                'emergency_contact_relationship' => $validated['emergency_contact_relationship'],
                'medical_conditions' => $validated['medical_conditions'],
                'allergies' => $validated['allergies'],
                'blood_group' => $validated['blood_group'],
                'admission_date' => $validated['admission_date'],
                'status' => $validated['status'],
                'previous_school' => $validated['previous_school'],
                'notes' => $validated['notes'],
            ]);

            DB::commit();

            return redirect()->route('students.show', $student)
                ->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating student', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error updating student: ' . $e->getMessage()]);
        }
    }

    public function destroy(Student $student)
    {
        // Check if user has permission to delete this student
        if (Auth::user()->school_id !== $student->school_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            // Get the user ID before deleting the student
            $userId = $student->user_id;

            // Delete the student record (this will use soft delete if configured)
            $student->delete();

            // Delete the associated user account
            User::find($userId)->delete();

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting student', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'student_id' => $student->id
            ]);

            return back()->withErrors(['error' => 'Error deleting student: ' . $e->getMessage()]);
        }
    }

    // ... other methods
} 