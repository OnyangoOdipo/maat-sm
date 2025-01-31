@extends('layouts.dashboard')

@section('title', 'Add New Teacher')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Add New Teacher</h2>
        <a href="{{ route('teachers.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('teachers.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Personal Information -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address" name="address" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Professional Information -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="qualification" class="block text-sm font-medium text-gray-700">Qualification</label>
                    <input type="text" id="qualification" name="qualification" value="{{ old('qualification') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('qualification')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                    <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="joining_date" class="block text-sm font-medium text-gray-700">Joining Date</label>
                    <input type="date" id="joining_date" name="joining_date" value="{{ old('joining_date') }}"
                           class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('joining_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
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
                    Create Teacher
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 