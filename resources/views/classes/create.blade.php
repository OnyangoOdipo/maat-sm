@extends('layouts.dashboard')

@section('title', 'Create New Class')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Create New Class</h2>
        <a href="{{ route('classes.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('classes.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            
            <!-- Section Selection -->
            <div class="mb-6">
                <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                <select id="section_id" name="section_id" class="mt-1 block w-full rounded-md border-gray-300" required
                        x-data="{ selectedSection: '' }"
                        x-on:change="selectedSection = $event.target.value">
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
                @error('section_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Level Selection (Dynamic) -->
            <div class="mb-6">
                <label for="class_level_id" class="block text-sm font-medium text-gray-700">Class Level</label>
                <select id="class_level_id" name="class_level_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value="">Select Class Level</option>
                </select>
                @error('class_level_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stream -->
            <div class="mb-6">
                <label for="stream" class="block text-sm font-medium text-gray-700">Stream</label>
                <input type="text" id="stream" name="stream" class="mt-1 block w-full rounded-md border-gray-300" required
                       placeholder="e.g., A, B, C">
                @error('stream')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity -->
            <div class="mb-6">
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number" id="capacity" name="capacity" class="mt-1 block w-full rounded-md border-gray-300"
                       placeholder="Maximum number of students">
                @error('capacity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Room Number -->
            <div class="mb-6">
                <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" id="room_number" name="room_number" class="mt-1 block w-full rounded-md border-gray-300"
                       placeholder="e.g., R101">
                @error('room_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Teacher -->
            <div class="mb-6">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Class Teacher</label>
                <select id="teacher_id" name="teacher_id" class="mt-1 block w-full rounded-md border-gray-300">
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Create Class
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sectionSelect = document.getElementById('section_id');
    const classLevelSelect = document.getElementById('class_level_id');

    sectionSelect.addEventListener('change', async function() {
        const sectionId = this.value;
        classLevelSelect.innerHTML = '<option value="">Select Class Level</option>';
        
        if (!sectionId) return;

        try {
            const response = await fetch(`/api/sections/${sectionId}/class-levels`);
            if (!response.ok) throw new Error('Failed to fetch class levels');
            
            const data = await response.json();
            data.forEach(level => {
                const option = new Option(level.name, level.id);
                classLevelSelect.add(option);
            });
        } catch (error) {
            console.error('Error:', error);
            // Optionally show an error message to the user
            alert('Failed to load class levels. Please try again.');
        }
    });
});
</script>
@endpush
@endsection 