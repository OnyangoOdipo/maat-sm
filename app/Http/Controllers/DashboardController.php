<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\ClassRoom;

class DashboardController extends Controller
{
    public function superadmin()
    {
        $stats = [
            'total_schools' => School::count(),
            'active_schools' => School::where('status', 'active')->count(),
            'total_teachers' => Teacher::count(),
        ];
        
        $recent_schools = School::latest()->take(5)->get();
        
        return view('dashboards.superadmin', compact('stats', 'recent_schools'));
    }

    public function schooladmin()
    {
        // Initialize empty stats in case school is not found
        $stats = [
            'total_teachers' => 0,
            'total_classes' => 0,
            'active_teachers' => 0,
        ];
        
        $recent_teachers = collect(); // Empty collection

        // Only try to get stats if user has a school
        if (auth()->user() && auth()->user()->school) {
            $school = auth()->user()->school;
            $stats = [
                'total_teachers' => $school->teachers()->count(),
                'total_classes' => $school->classRooms()->count(),
                'active_teachers' => $school->teachers()->where('status', 'active')->count(),
            ];
            
            $recent_teachers = $school->teachers()->latest()->take(5)->get();
        }
        
        return view('dashboards.schooladmin', compact('stats', 'recent_teachers'));
    }

    public function teacher()
    {
        // Initialize empty stats in case teacher is not found
        $stats = [
            'total_classes' => 0,
            'total_students' => 0,
        ];

        // Only try to get stats if user has a teacher profile
        if (auth()->user() && auth()->user()->teacher) {
            $teacher = auth()->user()->teacher;
            $stats = [
                'total_classes' => $teacher->classes()->count(),
                'total_students' => $teacher->students()->count(),
            ];
        }
        
        return view('dashboards.teacher', compact('stats'));
    }
}