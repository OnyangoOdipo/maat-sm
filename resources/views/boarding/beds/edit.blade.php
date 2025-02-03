@extends('layouts.dashboard')

@section('title', 'Edit Bed')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">
            Edit Bed {{ $bed->bed_number }} in {{ $bed->cubicle->name }}
        </h2>
        <p class="text-gray-600">{{ $bed->cubicle->house->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('boarding.beds.update', $bed) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="needs_maintenance" value="1" 
                               {{ old('needs_maintenance', $bed->needs_maintenance) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Needs Maintenance</span>
                    </label>
                </div>

                <div>
                    <label for="maintenance_notes" class="block text-sm font-medium text-gray-700">Maintenance Notes</label>
                    <textarea name="maintenance_notes" id="maintenance_notes" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('maintenance_notes', $bed->maintenance_notes) }}</textarea>
                    @error('maintenance_notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('boarding.cubicles.show', $bed->cubicle_id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Update Bed
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(!$bed->is_occupied)
    <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Student</h3>
            <form action="{{ route('boarding.beds.assign', $bed) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                        <select name="student_id" id="student_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select a student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="assigned_date" class="block text-sm font-medium text-gray-700">Assignment Date</label>
                        <input type="date" name="assigned_date" id="assigned_date" 
                               value="{{ old('assigned_date', date('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="2" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Assign Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection 