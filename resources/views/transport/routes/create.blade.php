<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Route') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('transport.routes.store') }}" class="space-y-6" x-data="routeForm()">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Route Name -->
                            <div>
                                <x-input-label for="name" :value="__('Route Name')" />
                                <x-text-input id="name" name="name" type="text" 
                                    class="mt-1 block w-full" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Fee Amount -->
                            <div>
                                <x-input-label for="fee_amount" :value="__('Fee Amount')" />
                                <x-text-input id="fee_amount" name="fee_amount" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('fee_amount')" required />
                                <x-input-error :messages="$errors->get('fee_amount')" class="mt-2" />
                            </div>

                            <!-- Morning Pickup Time -->
                            <div>
                                <x-input-label for="morning_pickup_time" :value="__('Morning Pickup Time')" />
                                <x-text-input id="morning_pickup_time" name="morning_pickup_time" type="time" 
                                    class="mt-1 block w-full" :value="old('morning_pickup_time')" required />
                                <x-input-error :messages="$errors->get('morning_pickup_time')" class="mt-2" />
                            </div>

                            <!-- Evening Departure Time -->
                            <div>
                                <x-input-label for="evening_departure_time" :value="__('Evening Departure Time')" />
                                <x-text-input id="evening_departure_time" name="evening_departure_time" type="time" 
                                    class="mt-1 block w-full" :value="old('evening_departure_time')" required />
                                <x-input-error :messages="$errors->get('evening_departure_time')" class="mt-2" />
                            </div>

                            <!-- Vehicle -->
                            <div>
                                <x-input-label for="vehicle_id" :value="__('Vehicle')" />
                                <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->registration_number }} ({{ $vehicle->model }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                            </div>

                            <!-- Driver -->
                            <div>
                                <x-input-label for="driver_id" :value="__('Driver')" />
                                <select id="driver_id" name="driver_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name }} ({{ $driver->phone }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('driver_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Stops -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Route Stops') }}</h3>
                                <button type="button" @click="addStop" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Add Stop
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(stop, index) in stops" :key="index">
                                    <div class="border rounded-lg p-4 relative">
                                        <button type="button" @click="removeStop(index)" 
                                            class="absolute top-2 right-2 text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <x-input-label :value="__('Stop Name')" />
                                                <x-text-input type="text" x-model="stop.name" 
                                                    :name="'stops[' + index + '][name]'"
                                                    class="mt-1 block w-full" required />
                                            </div>
                                            <div>
                                                <x-input-label :value="__('Morning Time')" />
                                                <x-text-input type="time" x-model="stop.morning_time"
                                                    :name="'stops[' + index + '][morning_time]'"
                                                    class="mt-1 block w-full" required />
                                            </div>
                                            <div>
                                                <x-input-label :value="__('Evening Time')" />
                                                <x-text-input type="time" x-model="stop.evening_time"
                                                    :name="'stops[' + index + '][evening_time]'"
                                                    class="mt-1 block w-full" required />
                                            </div>
                                        </div>
                                        <input type="hidden" x-model="stop.sequence" :name="'stops[' + index + '][sequence]'" />
                                    </div>
                                </template>
                            </div>
                            @error('stops')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Route') }}</x-primary-button>
                            <a href="{{ route('transport.routes.index') }}" class="text-gray-600 hover:text-gray-900">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function routeForm() {
            return {
                stops: [],
                addStop() {
                    this.stops.push({
                        name: '',
                        morning_time: '',
                        evening_time: '',
                        sequence: this.stops.length + 1
                    });
                },
                removeStop(index) {
                    this.stops.splice(index, 1);
                    // Update sequences
                    this.stops.forEach((stop, i) => {
                        stop.sequence = i + 1;
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout> 