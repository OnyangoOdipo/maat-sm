@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-700 text-lg font-medium mb-2">Total Schools</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_schools'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-700 text-lg font-medium mb-2">Active Schools</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['active_schools'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-700 text-lg font-medium mb-2">Total Teachers</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_teachers'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Schools</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recent_schools as $school)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $school->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $school->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $school->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $school->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection