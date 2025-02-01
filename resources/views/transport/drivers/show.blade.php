<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Driver Details') }}
            </h2>
            <a href="{{ route('transport.drivers.edit', $driver) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Edit Driver') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Personal Information') }}</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <span class="text-gray-600">{{ __('Name:') }}</span>
                                        <span class="ml-2 text-gray-900">{{ $driver->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">{{ __('Phone:') }}</span>
                                        <span class="ml-2 text-gray-900">{{ $driver->phone }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">{{ __('Status:') }}</span>
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $driver->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($driver->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('License Information') }}</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <span class="text-gray-600">{{ __('License Number:') }}</span>
                                        <span class="ml-2 text-gray-900">{{ $driver->license_number }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">{{ __('License Expiry:') }}</span>
                                        <span class="ml-2 text-gray-900">{{ $driver->license_expiry->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($driver->notes)
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Notes') }}</h3>
                                <p class="mt-2 text-gray-600">{{ $driver->notes }}</p>
                            </div>
                        @endif

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Route Assignments') }}</h3>
                            @if($driver->routeAssignments->isEmpty())
                                <p class="mt-2 text-gray-600">{{ __('No route assignments found.') }}</p>
                            @else
                                <div class="mt-4 overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Route</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($driver->routeAssignments as $assignment)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->route->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->vehicle->registration_number }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->start_date->format('M d, Y') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $assignment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ ucfirst($assignment->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('transport.drivers.index') }}" 
                               class="text-blue-600 hover:text-blue-900">
                                {{ __('← Back to Drivers List') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 