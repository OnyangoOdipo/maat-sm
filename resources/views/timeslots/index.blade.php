@extends('layouts.dashboard')

@section('title', 'Timeslots')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-900">Timeslots</h2>
        <a href="{{ route('timeslots.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Generate Timeslots
        </a>
    </div>

    <div class="mt-8">
        @foreach($classLevels as $classLevel)
            @if(isset($timeslots[$classLevel->id]))
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ $classLevel->name }}</h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                @if(isset($timeslots[$classLevel->id][$day]))
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-4">{{ $day }}</h4>
                                        <div class="space-y-3">
                                            @foreach($timeslots[$classLevel->id][$day] as $slot)
                                                <div class="p-3 rounded-md {{ $slot->is_break ? 'bg-orange-50 border border-orange-200' : 'bg-gray-50' }}">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm font-medium">
                                                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - 
                                                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                                        </span>
                                                        @if($slot->is_break)
                                                            <span class="text-xs px-2 py-1 rounded-full {{ $slot->type === 'lunch' ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                                {{ $slot->getDurationInMinutes() }} min
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if(!$slot->is_break)
                                                        <div class="mt-1 text-sm text-gray-500">
                                                            Lesson {{ $slot->slot_number }}
                                                        </div>
                                                    @else
                                                        <div class="mt-1 text-sm {{ $slot->type === 'lunch' ? 'text-orange-800' : 'text-yellow-800' }} font-medium">
                                                            {{ ucfirst($slot->type) }} Time
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection 