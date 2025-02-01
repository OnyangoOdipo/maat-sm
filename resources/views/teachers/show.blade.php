@extends('layouts.dashboard')

@section('title', 'Teacher Details')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-900">{{ __('Teacher Details') }}</h2>
        <div class="flex space-x-4">
            <a href="{{ route('teachers.edit', $teacher) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Edit Teacher') }}
            </a>
        </div>
    </div>

    <div class="mt-8 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Basic Information') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Name') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Employee Number') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->employee_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Email') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Phone') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Professional Information') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Qualification') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->qualification }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Subject Specialization') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->subject?->name ?? 'Not Assigned' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Joining Date') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ $teacher->joining_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Status') }}</p>
                        <p class="text-base font-medium text-gray-900">{{ ucfirst($teacher->status) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Classes -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Assigned Classes') }}</h3>
                @if($teacher->classRooms->isEmpty())
                    <p class="text-gray-500">{{ __('No classes assigned yet.') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Class') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Stream') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Students') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($teacher->classRooms as $class)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $class->classLevel->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $class->stream }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $class->students_count ?? 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('teachers.index') }}" 
               class="text-blue-600 hover:text-blue-900">
                {{ __('← Back to Teachers List') }}
            </a>
        </div>
    </div>
</div>
@endsection 