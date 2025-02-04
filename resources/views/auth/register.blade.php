<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6 max-w-7xl mx-auto">
        @csrf

        <!-- School and Admin Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- School Information -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-medium text-gray-900 mb-4">School Information</h2>
                <div class="space-y-4">
                    <!-- School Name -->
                    <div>
                        <x-input-label for="school_name" :value="__('School Name')" />
                        <x-text-input id="school_name" class="block mt-1 w-full" type="text" name="school_name" :value="old('school_name')" required />
                        <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                    </div>

                    <!-- School Email -->
                    <div>
                        <x-input-label for="school_email" :value="__('School Email')" />
                        <x-text-input id="school_email" class="block mt-1 w-full" type="email" name="school_email" :value="old('school_email')" required />
                        <x-input-error :messages="$errors->get('school_email')" class="mt-2" />
                    </div>

                    <!-- School Phone -->
                    <div>
                        <x-input-label for="school_phone" :value="__('School Phone')" />
                        <x-text-input id="school_phone" class="block mt-1 w-full" type="text" name="school_phone" :value="old('school_phone')" required />
                        <x-input-error :messages="$errors->get('school_phone')" class="mt-2" />
                    </div>

                    <!-- School Address -->
                    <div>
                        <x-input-label for="address" :value="__('School Address')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Admin Information -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Admin Information</h2>
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Admin Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Admin Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Curriculum Selection -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Select Curriculum Types</h2>
                <p class="text-sm text-gray-500 mb-6">Choose the curriculum types that your school will offer</p>
                
                <div class="space-y-4">
                    @foreach($availableCurriculums as $curriculum)
                        <label for="curriculum_{{ $curriculum['code'] }}" 
                               class="relative block p-4 border rounded-lg cursor-pointer hover:border-indigo-500 transition-colors">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                    id="curriculum_{{ $curriculum['code'] }}" 
                                    name="curriculums[]" 
                                    value="{{ $curriculum['code'] }}"
                                    class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-3 text-lg font-medium text-gray-900">{{ $curriculum['name'] }}</span>
                            </div>
                            <p class="mt-2 pl-8 text-sm text-gray-500">{{ $curriculum['description'] }}</p>
                        </label>
                    @endforeach
                </div>
                
                @error('curriculums')
                    <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <div class="mt-6 flex items-center text-sm text-gray-500">
                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    You can modify curriculum settings after registration
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
