@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Timetable for {{ $timetable->class_level?->name ?? 'Unknown Class' }}
        </h1>
        <p class="text-gray-600">Generated on {{ $timetable->created_at?->format('M d, Y') ?? 'Unknown Date' }}</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Time
                        </th>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($timeSlots->first())
                        @foreach($timeSlots->first() as $timeSlot)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $timeSlot->start_time?->format('H:i') }} - {{ $timeSlot->end_time?->format('H:i') }}
                                </td>
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(isset($slots[$day]))
                                            @php
                                                $slot = $slots[$day]->first(function($slot) use ($timeSlot) {
                                                    return $slot->timeSlot?->id === $timeSlot->id;
                                                });
                                            @endphp
                                            @if($slot)
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $slot->subject?->name ?? 'No Subject' }}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{ $slot->teacher?->name ?? 'No Teacher' }}
                                                    </div>
                                                    <div class="text-gray-400 text-xs">
                                                        {{ $slot->classroom?->name ?? 'No Classroom' }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No time slots available
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('timetables.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Back to List
        </a>
        <button onclick="window.print()" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
            Print Timetable
        </button>
    </div>
</div>
@endsection 