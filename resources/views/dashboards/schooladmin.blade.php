@extends('layouts.dashboard')

@section('title', 'School Admin Dashboard')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="grid gap-6 mb-8 md:grid-cols-3">
        <!-- Teachers Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 bg-blue-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Teachers</p>
                <p class="text-lg font-semibold text-gray-700">{{ $stats['total_teachers'] }}</p>
            </div>
        </div>

        <!-- Classes Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 bg-green-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Classes</p>
                <p class="text-lg font-semibold text-gray-700">{{ $stats['total_classes'] }}</p>
            </div>
        </div>

        <!-- Active Teachers Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 bg-purple-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Active Teachers</p>
                <p class="text-lg font-semibold text-gray-700">{{ $stats['active_teachers'] }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Teachers Table -->
    <div class="mt-8">
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Recent Teachers</h3>
                    <span class="text-base font-normal text-gray-500">This is a list of latest teachers</span>
                </div>
                <div class="flex-shrink-0">
                    <a href="#" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2">Add Teacher</a>
                </div>
            </div>
            <div class="flex flex-col mt-8">
                <div class="overflow-x-auto rounded-lg">
                    <div class="align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Joined Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse($recent_teachers as $teacher)
                                        <tr>
                                            <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                                {{ $teacher->user->name }}
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                                {{ $teacher->user->email }}
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $teacher->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $teacher->status }}
                                                </span>
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                                {{ $teacher->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-4 text-center text-sm text-gray-500">
                                                No teachers found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 