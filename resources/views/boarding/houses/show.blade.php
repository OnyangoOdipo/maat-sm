@extends('layouts.dashboard')

@section('title', $house->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-900">{{ $house->name }}</h2>
            <div class="flex space-x-4">
                <a href="{{ route('boarding.cubicles.create', ['house' => $house]) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Add Cubicle
                </a>
            </div>
        </div>
        <p class="text-gray-600">{{ ucfirst($house->gender) }} House</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Cubicles</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($house->cubicles as $cubicle)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-semibold">{{ $cubicle->name }}</h4>
                            <p class="text-sm text-gray-600">Floor {{ $cubicle->floor_number }}</p>
                        </div>
                        <a href="{{ route('boarding.cubicles.edit', $cubicle) }}" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-2">
                        @foreach($cubicle->beds as $bed)
                        <div class="flex justify-between items-center p-2 {{ $bed->is_occupied ? 'bg-red-50' : 'bg-green-50' }} rounded">
                            <span>Bed {{ $bed->bed_number }}</span>
                            @if($bed->is_occupied && $bed->currentAssignment)
                                <span class="text-sm text-gray-600">{{ $bed->currentAssignment->student->name }}</span>
                            @else
                                <span class="text-sm text-green-600">Available</span>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('boarding.cubicles.show', $cubicle) }}" 
                           class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200">
                            Manage Beds
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 