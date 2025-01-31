@extends('layouts.dashboard')

@section('title', 'Edit Class')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Edit Class</h2>
        <a href="{{ route('classes.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('classes.update', $class) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')
            
            <!-- Section Selection -->
            <div class="mb-6">
                <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                <select id="section_id" name="section_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ $class->section_id == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
                @error('section_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Level Selection -->
            <div class="mb-6">
                <label for="class_level_id" class="block text-sm font-medium text-gray-700">Class Level</label>
                <select id="class_level_id" name="class_level_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value="">Select Class Level</option>
                    @foreach($class->section->classLevels as $level)
                        <option value="{{ $level->id }}" {{ $class->class_level_id == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_level_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stream -->
            <div class="mb-6">
                <label for="stream" class="block text-sm font-medium text-gray-700">Stream</label>
                <input type="text" id="stream" name="stream" value="{{ $class->stream }}" 
                       class="mt-1 block w-full rounded-md border-gray-300" required>
                @error('stream')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity -->
            <div class="mb-6">
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number" id="capacity" name="capacity" value="{{ $class->capacity }}"
                       class="mt-1 block w-full rounded-md border-gray-300">
                @error('capacity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Teacher -->
            <div class="mb-6">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Class Teacher</label>
                <select id="teacher_id" name="teacher_id" class="mt-1 block w-full rounded-md border-gray-300">
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Room Number -->
            <div class="mb-6">
                <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" id="room_number" name="room_number" value="{{ $class->room_number }}"
                       class="mt-1 block w-full rounded-md border-gray-300">
                @error('room_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value="active" {{ $class->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $class->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300">{{ $class->notes }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Update Class
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

    sectionSelect.addEventListener('change', function() {
        const sectionId = this.value;
        if (sectionId) {
            fetch(`/api/sections/${sectionId}/class-levels`)
                .then(response => response.json())
                .then(data => {
                    classLevelSelect.innerHTML = '<option value="">Select Class Level</option>';
                    data.forEach(level => {
                        classLevelSelect.innerHTML += `<option value="${level.id}">${level.name}</option>`;
                    });
                });
        } else {
            classLevelSelect.innerHTML = '<option value="">Select Class Level</option>';
        }
    });
});
</script>
@endpush
@endsection 