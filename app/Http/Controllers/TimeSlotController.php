<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\ClassLevel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeslots = TimeSlot::with('classLevel')
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->groupBy(['class_level_id', 'day']);

        $classLevels = ClassLevel::where('school_id', auth()->user()->school_id)->get();

        return view('timeslots.index', compact('timeslots', 'classLevels'));
    }

    public function create()
    {
        $classLevels = ClassLevel::where('school_id', auth()->user()->school_id)->get();
        return view('timeslots.create', compact('classLevels'));
    }

    public function generateTimeslots(Request $request)
    {
        $validated = $request->validate([
            'generation_type' => 'required|in:manual,automatic',
            'class_level_ids' => 'required|array',
            'class_level_ids.*' => 'exists:class_levels,id',
            'days' => 'required|array',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'lesson_duration' => 'required|integer|min:30|max:120',
            'breaks' => 'required|array',
            'breaks.*.type' => 'required|in:break,lunch',
            'breaks.*.duration' => 'required|integer|min:10|max:60',
            'breaks.*.after_slot' => 'required|integer|min:1'
        ]);

        // Delete existing timeslots for selected class levels
        TimeSlot::where('school_id', auth()->user()->school_id)
            ->whereIn('class_level_id', $validated['class_level_ids'])
            ->delete();

        foreach ($validated['class_level_ids'] as $classLevelId) {
            foreach ($validated['days'] as $day) {
                $currentTime = Carbon::parse($validated['start_time']);
                $endTime = Carbon::parse($validated['end_time']);
                $slotNumber = 1;
                $lessonCount = 1; // Keep track of actual lesson numbers
                $lessonDuration = (int)$validated['lesson_duration'];

                while ($currentTime < $endTime) {
                    // Create regular lesson slot
                    TimeSlot::create([
                        'school_id' => auth()->user()->school_id,
                        'class_level_id' => $classLevelId,
                        'day' => $day,
                        'start_time' => $currentTime->format('H:i:s'),
                        'end_time' => $currentTime->copy()->addMinutes($lessonDuration)->format('H:i:s'),
                        'type' => 'regular',
                        'slot_number' => $lessonCount, // Use lessonCount for actual lessons
                        'is_break' => false,
                        'is_active' => true
                    ]);

                    $currentTime->addMinutes($lessonDuration);

                    // Check if we need to add a break after this lesson
                    foreach ($validated['breaks'] as $break) {
                        if ((int)$break['after_slot'] === $lessonCount) {
                            $breakDuration = (int)$break['duration'];
                            
                            // Create break slot after the lesson
                            TimeSlot::create([
                                'school_id' => auth()->user()->school_id,
                                'class_level_id' => $classLevelId,
                                'day' => $day,
                                'start_time' => $currentTime->format('H:i:s'),
                                'end_time' => $currentTime->copy()->addMinutes($breakDuration)->format('H:i:s'),
                                'type' => $break['type'],
                                'slot_number' => 0, // Use 0 for breaks to distinguish them
                                'is_break' => true,
                                'is_active' => true
                            ]);
                            
                            $currentTime->addMinutes($breakDuration);
                            break;
                        }
                    }

                    $lessonCount++; // Only increment lesson count for actual lessons
                }
            }
        }

        return redirect()->route('timeslots.index')
            ->with('success', 'Timeslots generated successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'generation_type' => 'required|in:manual,automatic',
            'class_level_id' => 'required|exists:class_levels,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'type' => 'required|in:regular,break,lunch,assembly',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_number' => 'required_if:type,regular|nullable|integer|min:1',
        ]);

        // Check for time slot conflicts
        $exists = TimeSlot::where('school_id', auth()->user()->school_id)
            ->where('class_level_id', $validated['class_level_id'])
            ->where('day', $validated['day'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                          ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['time_conflict' => 'This time slot overlaps with an existing slot.'])
                        ->withInput();
        }

        // Create the time slot
        TimeSlot::create([
            'school_id' => auth()->user()->school_id,
            'class_level_id' => $validated['class_level_id'],
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'type' => $validated['type'],
            'slot_number' => $validated['type'] === 'regular' ? $validated['slot_number'] : 0,
            'is_break' => in_array($validated['type'], ['break', 'lunch']),
            'is_active' => true
        ]);

        return redirect()->route('timeslots.index')
            ->with('success', 'Timeslot added successfully.');
    }

    // Other methods...
} 