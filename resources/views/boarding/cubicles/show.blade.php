@extends('layouts.dashboard')

@section('title', $cubicle->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">{{ $cubicle->name }}</h2>
                <p class="text-gray-600">{{ ucfirst($cubicle->type) }} Cubicle - Floor {{ $cubicle->floor_number }}</p>
            </div>
            <a href="{{ route('boarding.houses.show', $cubicle->house) }}" 
               class="text-blue-600 hover:text-blue-800">
                Back to {{ $cubicle->house->name }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Beds</h3>
            
            <div class="space-y-4">
                @foreach($cubicle->beds as $bed)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold">Bed {{ $bed->bed_number }}</h4>
                            <div class="mt-1">
                                @if($bed->is_occupied && $bed->currentAssignment)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Occupied by {{ $bed->currentAssignment->student->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @endif
                                
                                @if($bed->needs_maintenance)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Needs Maintenance
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            @if(!$bed->is_occupied)
                                <button type="button" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                    Assign Student
                                </button>
                            @else
                                <button type="button"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                    Remove Assignment
                                </button>
                            @endif
                            
                            <button type="button" 
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 text-sm">
                                {{ $bed->needs_maintenance ? 'Mark Fixed' : 'Mark for Maintenance' }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
