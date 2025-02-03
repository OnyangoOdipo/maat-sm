@extends('layouts.dashboard')

@section('title', 'Bed Details')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">
                    Bed {{ $bed->bed_number }} in {{ $bed->cubicle->name }}
                </h2>
                <p class="text-gray-600">{{ $bed->cubicle->house->name }}</p>
            </div>
            <a href="{{ route('boarding.beds.edit', $bed) }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Edit Bed
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Bed Status -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Bed Status</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium {{ $bed->is_occupied ? 'text-red-600' : 'text-green-600' }}">
                            {{ $bed->is_occupied ? 'Occupied' : 'Available' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Maintenance Required:</span>
                        <span class="font-medium {{ $bed->needs_maintenance ? 'text-red-600' : 'text-green-600' }}">
                            {{ $bed->needs_maintenance ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    @if($bed->maintenance_notes)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700">Maintenance Notes:</h4>
                        <p class="mt-1 text-sm text-gray-600">{{ $bed->maintenance_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Current Assignment -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Assignment</h3>
                @if($bed->currentAssignment)
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Student:</span>
                            <span class="font-medium">{{ $bed->currentAssignment->student->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Assigned Date:</span>
                            <span class="font-medium">{{ $bed->currentAssignment->assigned_date->format('M d, Y') }}</span>
                        </div>
                        @if($bed->currentAssignment->notes)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-700">Assignment Notes:</h4>
                            <p class="mt-1 text-sm text-gray-600">{{ $bed->currentAssignment->notes }}</p>
                        </div>
                        @endif
                        <div class="mt-6">
                            <form action="{{ route('boarding.beds.unassign', $bed) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                    Unassign Student
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600">No current assignment</p>
                    <div class="mt-4">
                        <a href="{{ route('boarding.beds.edit', $bed) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Assign Student
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 