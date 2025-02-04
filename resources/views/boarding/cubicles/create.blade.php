@extends('layouts.dashboard')

@section('title', 'Add Cubicle')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Add Cubicle to {{ $house->name }}</h2>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('boarding.cubicles.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="house_id" value="{{ $house->id }}">
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Cubicle Name/Number</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" id="type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="prefect" {{ old('type') == 'prefect' ? 'selected' : '' }}>Prefect</option>
                        <option value="special_needs" {{ old('type') == 'special_needs' ? 'selected' : '' }}>Special Needs</option>
                        <option value="isolation" {{ old('type') == 'isolation' ? 'selected' : '' }}>Isolation</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity (Number of Beds)</label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="floor_number" class="block text-sm font-medium text-gray-700">Floor Number</label>
                    <input type="number" name="floor_number" id="floor_number" value="{{ old('floor_number', 1) }}" min="1" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('floor_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('boarding.houses.show', $house) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Create Cubicle
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 