@extends('layouts.dashboard')

@section('title', 'Student Details')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Student Details</h1>
            <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-gray-900">
                Back to List
            </a>
        </div>

        <!-- Student Information Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Basic Information -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="mt-1">{{ $student->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Admission Number</p>
                        <p class="mt-1">{{ $student->admission_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Class</p>
                        <p class="mt-1">
                            @if($student->class && $student->class->classLevel)
                                {{ $student->class->classLevel->name }} {{ $student->class->stream }}
                            @else
                                Not assigned
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Roll Number</p>
                        <p class="mt-1">{{ $student->roll_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="mt-1">{{ $student->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Phone</p>
                        <p class="mt-1">{{ $student->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Address</p>
                        <p class="mt-1">{{ $student->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Parent/Guardian Information -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Parent Name</p>
                        <p class="mt-1">{{ $student->parent_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Parent Phone</p>
                        <p class="mt-1">{{ $student->parent_phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Parent Email</p>
                        <p class="mt-1">{{ $student->parent_email ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Relationship</p>
                        <p class="mt-1">{{ ucfirst($student->parent_relationship) }}</p>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Medical Information</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Medical Conditions</p>
                        <p class="mt-1">{{ $student->medical_conditions ?? 'None' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Allergies</p>
                        <p class="mt-1">{{ $student->allergies ?? 'None' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Blood Group</p>
                        <p class="mt-1">{{ $student->blood_group ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('students.edit', $student) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Student
            </a>
            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Are you sure you want to delete this student?')">
                    Delete Student
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 