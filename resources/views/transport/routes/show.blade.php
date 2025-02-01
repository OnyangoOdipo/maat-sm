<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Route Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('transport.routes.edit', $route) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit Route') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Basic Route Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Route Information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Route Name') }}</p>
                            <p class="text-base font-medium text-gray-900">{{ $route->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Fee Amount') }}</p>
                            <p class="text-base font-medium text-gray-900">{{ number_format($route->fee_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Morning Pickup Time') }}</p>
                            <p class="text-base font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($route->morning_pickup_time)->format('h:i A') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Evening Departure Time') }}</p>
                            <p class="text-base font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($route->evening_departure_time)->format('h:i A') }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">{{ __('Description') }}</p>
                            <p class="text-base text-gray-900">{{ $route->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Assignment -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Current Assignment') }}</h3>
                    @if($currentAssignment = $route->assignments->where('status', 'active')->first())
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Driver') }}</p>
                                <p class="text-base font-medium text-gray-900">{{ $currentAssignment->driver->name }}</p>
                                <p class="text-sm text-gray-500">{{ $currentAssignment->driver->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Vehicle') }}</p>
                                <p class="text-base font-medium text-gray-900">{{ $currentAssignment->vehicle->registration_number }}</p>
                                <p class="text-sm text-gray-500">{{ $currentAssignment->vehicle->model }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('Start Date') }}</p>
                                <p class="text-base font-medium text-gray-900">{{ $currentAssignment->start_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No active assignment') }}</p>
                    @endif
                </div>
            </div>

            <!-- Route Stops -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Route Stops') }}</h3>
                    @if($route->stops->isEmpty())
                        <p class="text-gray-500">{{ __('No stops defined for this route.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Sequence') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Stop Name') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Morning Time') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Evening Time') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($route->stops->sortBy('sequence') as $stop)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $stop->sequence }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $stop->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($stop->morning_time)->format('h:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($stop->evening_time)->format('h:i A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Assignment History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Assignment History') }}</h3>
                    @if($route->assignments->where('status', 'inactive')->isEmpty())
                        <p class="text-gray-500">{{ __('No previous assignments.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Period') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Driver') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Vehicle') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($route->assignments->where('status', 'inactive')->sortByDesc('start_date') as $assignment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $assignment->start_date->format('M d, Y') }} - 
                                                {{ $assignment->end_date ? $assignment->end_date->format('M d, Y') : 'Present' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $assignment->driver->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $assignment->driver->phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $assignment->vehicle->registration_number }}</div>
                                                <div class="text-sm text-gray-500">{{ $assignment->vehicle->model }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-start">
                <a href="{{ route('transport.routes.index') }}" 
                   class="text-blue-600 hover:text-blue-900">
                    {{ __('← Back to Routes List') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 