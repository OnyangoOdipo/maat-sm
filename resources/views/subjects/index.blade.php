@extends('layouts.dashboard')

@section('title', 'Subject Management')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-900">Subjects</h2>
        <a href="{{ route('subjects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            Add New Subject
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="mt-6 bg-white rounded-lg shadow p-4">
        <form action="{{ route('subjects.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       placeholder="Search subjects..." 
                       class="w-full rounded-md border-gray-300"
                       value="{{ request('search') }}">
            </div>
            <div class="w-48">
                <select name="type" class="w-full rounded-md border-gray-300">
                    <option value="">All Types</option>
                    <option value="core" {{ request('type') == 'core' ? 'selected' : '' }}>Core</option>
                    <option value="elective" {{ request('type') == 'elective' ? 'selected' : '' }}>Elective</option>
                    <option value="optional" {{ request('type') == 'optional' ? 'selected' : '' }}>Optional</option>
                </select>
            </div>
            <div class="w-48">
                <select name="status" class="w-full rounded-md border-gray-300">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Filter
            </button>
        </form>
    </div>

    <!-- Subjects Table -->
    <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subject
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Code
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Teachers
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($subjects as $subject)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $subject->name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ Str::limit($subject->description, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $subject->code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $subject->subject_type === 'core' ? 'bg-green-100 text-green-800' : 
                                   ($subject->subject_type === 'elective' ? 'bg-blue-100 text-blue-800' : 
                                    'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($subject->subject_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $subject->teachers->count() }} Teachers
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $subject->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($subject->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('subjects.show', $subject) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                View
                            </a>
                            <a href="{{ route('subjects.edit', $subject) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Edit
                            </a>
                            <button onclick="deleteSubject({{ $subject->id }})" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No subjects found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $subjects->links() }}
    </div>
</div>

@push('scripts')
<script>
function deleteSubject(id) {
    if (confirm('Are you sure you want to delete this subject?')) {
        fetch(`/subjects/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error deleting subject. It might be in use.');
            }
        });
    }
}
</script>
@endpush
@endsection 