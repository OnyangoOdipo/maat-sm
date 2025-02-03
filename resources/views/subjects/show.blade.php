@extends('layouts.dashboard')

@section('title', 'Subject Details')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">{{ $subject->name }}</h2>
        <div class="flex space-x-4">
            <a href="{{ route('subjects.edit', $subject) }}" 
               class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
                Edit Subject
            </a>
            <a href="{{ route('subjects.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Back to List
            </a>
        </div>
    </div>

    <div class="mt-8 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
            </div>
            <div class="p-6 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Subject Code</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $subject->code }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Type</p>
                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($subject->subject_type) }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $subject->description ?? 'No description available' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $subject->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($subject->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Curriculum Types -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Curriculum Types</h3>
            </div>
            <div class="p-6">
                @if($subject->curriculumTypes->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($subject->curriculumTypes as $type)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-medium text-gray-900">{{ $type->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $type->code }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No curriculum types assigned</p>
                @endif
            </div>
        </div>

        <!-- Class Levels -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Class Levels</h3>
            </div>
            <div class="p-6">
                @if($subject->classLevels->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($subject->classLevels as $level)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-medium text-gray-900">{{ $level->name }}</h4>
                                <p class="text-sm text-gray-500">
                                    {{ $level->pivot->is_compulsory ? 'Compulsory' : 'Optional' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No class levels assigned</p>
                @endif
            </div>
        </div>

        <!-- Teachers -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Teachers</h3>
            </div>
            <div class="p-6">
                @if($subject->teachers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($subject->teachers as $teacher)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-medium text-gray-900">{{ $teacher->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $teacher->employee_number }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No teachers assigned</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 