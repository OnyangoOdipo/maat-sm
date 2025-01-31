@extends('layouts.dashboard')

@section('title', 'Class Management')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-900">Classes</h2>
        <a href="{{ route('classes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            Add New Class
        </a>
    </div>

    <!-- Sections and Classes -->
    <div class="mt-8 space-y-6">
        @forelse($sections as $section)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Section Header -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $section->name }}</h3>
                </div>

                <!-- Class Levels -->
                <div class="divide-y divide-gray-200">
                    @foreach($section->classLevels as $classLevel)
                        <div class="px-6 py-4">
                            <div class="mb-3">
                                <h4 class="text-md font-medium text-gray-700">{{ $classLevel->name }}</h4>
                            </div>
                            
                            <!-- Class Rooms -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($classLevel->classRooms as $classRoom)
                                    <div class="border rounded-lg p-4 bg-gray-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h5 class="font-medium">Stream {{ $classRoom->stream }}</h5>
                                                <p class="text-sm text-gray-600">
                                                    Students: {{ $classRoom->students_count }}
                                                    @if($classRoom->capacity)
                                                        / {{ $classRoom->capacity }}
                                                    @endif
                                                </p>
                                                @if($classRoom->teacher)
                                                    <p class="text-sm text-gray-600">
                                                        Teacher: {{ $classRoom->teacher->user->name }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('classes.edit', $classRoom) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <button onclick="deleteClass({{ $classRoom->id }})" 
                                                        class="text-red-600 hover:text-red-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Classes</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new class.</p>
                <div class="mt-6">
                    <a href="{{ route('classes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add New Class
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
function deleteClass(id) {
    if (confirm('Are you sure you want to delete this class?')) {
        fetch(`/classes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error deleting class. It might have students assigned.');
            }
        });
    }
}
</script>
@endpush
@endsection 