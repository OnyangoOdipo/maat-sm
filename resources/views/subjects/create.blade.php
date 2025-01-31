@extends('layouts.dashboard')

@section('title', 'Add New Subject')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Add New Subject</h2>
        <a href="{{ route('subjects.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('subjects.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject_type" class="block text-sm font-medium text-gray-700">Subject Type</label>
                    <select id="subject_type" name="subject_type" class="mt-1 block w-full rounded-md border-gray-300" required>
                        <option value="">Select Type</option>
                        <option value="core" {{ old('subject_type') == 'core' ? 'selected' : '' }}>Core</option>
                        <option value="elective" {{ old('subject_type') == 'elective' ? 'selected' : '' }}>Elective</option>
                        <option value="optional" {{ old('subject_type') == 'optional' ? 'selected' : '' }}>Optional</option>
                    </select>
                    @error('subject_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Curriculum Types -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Curriculum Types</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($curriculumTypes as $type)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="curriculum_type_{{ $type->id }}" 
                                   name="curriculum_types[]" 
                                   value="{{ $type->id }}"
                                   class="rounded border-gray-300 text-blue-600"
                                   {{ in_array($type->id, old('curriculum_types', [])) ? 'checked' : '' }}>
                            <label for="curriculum_type_{{ $type->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $type->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('curriculum_types')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Levels -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Levels</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($classLevels as $level)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="class_level_{{ $level->id }}" 
                                   name="class_levels[]" 
                                   value="{{ $level->id }}"
                                   class="rounded border-gray-300 text-blue-600"
                                   {{ in_array($level->id, old('class_levels', [])) ? 'checked' : '' }}>
                            <label for="class_level_{{ $level->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $level->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('class_levels')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Rooms and Teachers -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Specific Classrooms</label>
                <div class="space-y-4">
                    @foreach($classRooms as $classroom)
                        <div class="flex items-start space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="class_room_{{ $classroom->id }}" 
                                       name="class_rooms[]" 
                                       value="{{ $classroom->id }}"
                                       class="rounded border-gray-300 text-blue-600"
                                       {{ in_array($classroom->id, old('class_rooms', [])) ? 'checked' : '' }}>
                                <label for="class_room_{{ $classroom->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $classroom->name }}
                                </label>
                            </div>
                            <div class="flex-1">
                                <select name="teacher_id[{{ $classroom->id }}]" 
                                        class="block w-full rounded-md border-gray-300">
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                            {{ old("teacher_id.{$classroom->id}") == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('class_rooms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teachers -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subject Teachers</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($teachers as $teacher)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="teacher_{{ $teacher->id }}" 
                                   name="teachers[]" 
                                   value="{{ $teacher->id }}"
                                   class="rounded border-gray-300 text-blue-600"
                                   {{ in_array($teacher->id, old('teachers', [])) ? 'checked' : '' }}>
                            <label for="teacher_{{ $teacher->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $teacher->user->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('teachers')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Information -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Create Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 