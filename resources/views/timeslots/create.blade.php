@extends('layouts.dashboard')

@section('title', 'Generate Timeslots')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Generate Timeslots</h2>
        <a href="{{ route('timeslots.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="mt-8" x-data="{ 
        generationType: 'automatic',
        showAutomaticForm: true,
        selectedDays: [],
        breaks: [],
        addBreak() {
            this.breaks.push({
                type: 'break',
                duration: 20,
                after_slot: this.breaks.length + 1
            });
        },
        removeBreak(index) {
            this.breaks.splice(index, 1);
            // Update after_slot values
            this.breaks.forEach((break_, idx) => {
                break_.after_slot = idx + 1;
            });
        }
    }">
        <!-- Generation Type Selection -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" x-model="generationType" name="generation_type" value="automatic" class="form-radio">
                    <span class="ml-2">Automatic Generation</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" x-model="generationType" name="generation_type" value="manual" class="form-radio">
                    <span class="ml-2">Manual Entry</span>
                </label>
            </div>
        </div>

        <!-- Automatic Generation Form -->
        <form x-show="generationType === 'automatic'" action="{{ route('timeslots.generate') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="generation_type" value="automatic">

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Settings</h3>
                
                <!-- Class Levels -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Levels</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($classLevels as $level)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="class_level_ids[]" value="{{ $level->id }}" 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2">{{ $level->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Days Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">School Days</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="days[]" value="{{ $day }}" x-model="selectedDays"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Time Settings -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" name="start_time" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" name="end_time" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lesson Duration (minutes)</label>
                        <input type="number" name="lesson_duration" min="30" max="120" value="40" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Breaks Configuration -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Breaks Configuration</h3>
                    <button type="button" @click="addBreak"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Break
                    </button>
                </div>

                <template x-for="(break_, index) in breaks" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Break Type</label>
                            <select x-model="break_.type" :name="'breaks['+index+'][type]'"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="break">Short Break</option>
                                <option value="lunch">Lunch Break</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                            <input type="number" x-model="break_.duration" :name="'breaks['+index+'][duration]'"
                                   min="10" max="60" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex items-end space-x-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">After Lesson</label>
                                <input type="number" x-model="break_.after_slot" :name="'breaks['+index+'][after_slot]'"
                                       min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <button type="button" @click="removeBreak(index)"
                                    class="mb-1 text-red-600 hover:text-red-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Generate Timeslots
                </button>
            </div>
        </form>

        <!-- Manual Entry Form -->
        <div x-show="generationType === 'manual'" class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('timeslots.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="generation_type" value="manual">

                <!-- Class Level Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Level</label>
                    <select name="class_level_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Class Level</option>
                        @foreach($classLevels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Day Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Day</label>
                    <select name="day" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Day</option>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Slot Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" x-model="slotType" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="regular">Regular Lesson</option>
                        <option value="break">Short Break</option>
                        <option value="lunch">Lunch Break</option>
                        <option value="assembly">Assembly</option>
                    </select>
                </div>

                <!-- Time Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" name="start_time" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" name="end_time" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Lesson Number (only for regular lessons) -->
                <div x-show="slotType === 'regular'" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lesson Number</label>
                    <input type="number" name="slot_number" min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('timeslots.index') }}" 
                       class="px-4 py-2 text-gray-700 hover:text-gray-900">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add Timeslot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Additional JavaScript if needed
</script>
@endpush
@endsection 