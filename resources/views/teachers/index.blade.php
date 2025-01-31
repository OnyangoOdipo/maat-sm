@extends('layouts.dashboard')

@section('title', 'Teachers Management')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-900">Teachers</h2>
        <a href="{{ route('teachers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            Add New Teacher
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="mt-6 bg-white rounded-lg shadow p-4">
        <form action="{{ route('teachers.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       placeholder="Search teachers..." 
                       class="w-full rounded-md border-gray-300"
                       value="{{ request('search') }}">
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

    <!-- Teachers Table -->
    <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Teacher
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Employee Number
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Specialization
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
                @forelse($teachers as $teacher)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $teacher->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $teacher->user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $teacher->employee_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $teacher->specialization }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $teacher->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($teacher->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('teachers.show', $teacher) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                View
                            </a>
                            <a href="{{ route('teachers.edit', $teacher) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Edit
                            </a>
                            <button onclick="deleteTeacher({{ $teacher->id }})" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No teachers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $teachers->links() }}
    </div>
</div>

@push('scripts')
<script>
function deleteTeacher(id) {
    if (confirm('Are you sure you want to delete this teacher?')) {
        fetch(`/teachers/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error deleting teacher. They might have assigned classes.');
            }
        });
    }
}
</script>
@endpush
@endsection 