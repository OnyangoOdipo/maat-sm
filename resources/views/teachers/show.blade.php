<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teacher Details') }}
            </h2>
            <a href="{{ route('teachers.edit', $teacher) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Edit Teacher') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Personal Information') }}</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <span class="text-gray-600">{{ __('Name:') }}</span>
                                    <span class="ml-2 text-gray-900">{{ $teacher->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">{{ __('Email:') }}</span>
                                    <span class="ml-2 text-gray-900">{{ $teacher->email }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">{{ __('Phone:') }}</span>
                                    <span class="ml-2 text-gray-900">{{ $teacher->phone }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Assigned Subjects') }}</h3>
                            <div class="mt-4">
                                @if($teacher->subjects->count() > 0)
                                    <ul class="list-disc list-inside space-y-2">
                                        @foreach($teacher->subjects as $subject)
                                            <li class="text-gray-600">{{ $subject->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-600">{{ __('No subjects assigned yet.') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('teachers.index') }}" 
                               class="text-blue-600 hover:text-blue-900">
                                {{ __('← Back to Teachers List') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 