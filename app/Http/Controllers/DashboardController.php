<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Section;

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
        $school = auth()->user()->school;
        $sections = Section::where('school_id', $school->id)
            ->with(['classLevels.classrooms' => function($query) {
                $query->withCount('students');
            }])
            ->get();

        return view('dashboard.schooladmin', compact('sections'));
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