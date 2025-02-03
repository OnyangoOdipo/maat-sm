@extends('layouts.dashboard')

@section('title', 'Edit Subject')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Edit Subject</h2>
        <a href="{{ route('subjects.show', $subject) }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('subjects.update', $subject) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $subject->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $subject->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject_type" class="block text-sm font-medium text-gray-700">Subject Type</label>
                    <select id="subject_type" name="subject_type" class="mt-1 block w-full rounded-md border-gray-300" required>
                        <option value="core" {{ old('subject_type', $subject->subject_type) === 'core' ? 'selected' : '' }}>Core</option>
                        <option value="elective" {{ old('subject_type', $subject->subject_type) === 'elective' ? 'selected' : '' }}>Elective</option>
                        <option value="optional" {{ old('subject_type', $subject->subject_type) === 'optional' ? 'selected' : '' }}>Optional</option>
                    </select>
                    @error('subject_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Curriculum Types -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Curriculum Types</label>
                    <div class="mt-2 space-y-2">
                        @foreach($curriculumTypes as $type)
                            <div class="flex items-center">
                                <input type="checkbox" id="curriculum_type_{{ $type->id }}" 
                                       name="curriculum_types[]" value="{{ $type->id }}"
                                       class="rounded border-gray-300 text-indigo-600"
                                       {{ in_array($type->id, old('curriculum_types', $subject->curriculumTypes->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                <div>
                    <label class="block text-sm font-medium text-gray-700">Class Levels</label>
                    <div class="mt-2 space-y-2">
                        @foreach($classLevels as $level)
                            <div class="flex items-center">
                                <input type="checkbox" id="class_level_{{ $level->id }}" 
                                       name="class_levels[]" value="{{ $level->id }}"
                                       class="rounded border-gray-300 text-indigo-600"
                                       {{ in_array($level->id, old('class_levels', $subject->classLevels->pluck('id')->toArray())) ? 'checked' : '' }}>
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

                <!-- Teachers -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Teachers</label>
                    <div class="mt-2 space-y-2">
                        @foreach($teachers as $teacher)
                            <div class="flex items-center">
                                <input type="checkbox" id="teacher_{{ $teacher->id }}" 
                                       name="teachers[]" value="{{ $teacher->id }}"
                                       class="rounded border-gray-300 text-indigo-600"
                                       {{ in_array($teacher->id, old('teachers', $subject->teachers->pluck('id')->toArray())) ? 'checked' : '' }}>
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

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300" required>
                        <option value="active" {{ old('status', $subject->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $subject->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Update Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 