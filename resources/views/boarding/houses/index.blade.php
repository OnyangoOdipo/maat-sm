@extends('layouts.dashboard')

@section('title', 'Boarding Management')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Houses/Dormitories</h2>
        <a href="{{ route('boarding.houses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Add New House
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($houses as $house)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $house->name }}</h3>
                        <p class="text-sm text-gray-600">{{ ucfirst($house->gender) }} House</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('boarding.houses.edit', $house) }}" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Total Capacity:</span>
                        <span>{{ $house->total_capacity }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Occupied:</span>
                        <span>{{ $house->cubicles->sum(function($cubicle) {
                            return $cubicle->beds->where('is_occupied', true)->count();
                        }) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Available:</span>
                        <span>{{ $house->total_capacity - $house->cubicles->sum(function($cubicle) {
                            return $cubicle->beds->where('is_occupied', true)->count();
                        }) }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('boarding.houses.show', $house) }}" 
                       class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 