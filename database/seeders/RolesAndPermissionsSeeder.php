<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear cached roles & permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'manage_users',
            'view_reports',
            'edit_timetable',
            'manage_exams',
            'manage_fees',
            'view_financial_reports',
            'manage_inventory',
            'view_all_reports',
            'approve_exams',
            'manage_staff',
            'view_student_performance',
            'assign_subjects',
            'manage_subject_teachers',
            'approve_exam_papers',
            'view_subject_reports',
            'view_class_students',
            'edit_student_records',
            'manage_class_discipline',
            'add_grades',
            'edit_exam_papers',
            'view_subject_students',
            'access_student_discipline',
            'provide_guidance',
            'manage_payroll',
            'manage_library',
            'issue_books',
            'track_library_fines',
            'manage_lab_equipment',
            'track_experiment_requests',
            'manage_erp_settings',
            'reset_user_passwords',
            'access_medical_records',
            'manage_student_health',
            'manage_visitors',
            'answer_calls',
            'manage_transport_routes',
            'assign_drivers',
            'monitor_security',
            'manage_gate_access',
            'view_student_attendance',
            'view_student_grades',
            'view_student_timetable',
            'view_student_discipline',
            'receive_notifications',
            'view_own_timetable',
            'view_own_grades',
            'view_own_attendance',
            'submit_assignments',
            'view_own_discipline',
            'manage_boarding_students',
            'manage_boarding_facilities',
            'view_boarding_reports',
            'manage_sports_activities',
            'manage_sports_equipment',
            'view_sports_reports',
            'manage_exam_schedules',
            'manage_exam_results',
            'view_exam_reports',
            'manage_curriculum',
            'edit_curriculum_content',
            'view_curriculum_reports'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their permissions
        $roles = [
            'Admin' => [
                'manage_users',
                'view_reports',
                'edit_timetable',
                'manage_exams',
                'manage_fees',
                'manage_inventory'
            ],
            'Principal' => [
                'view_all_reports',
                'approve_exams',
                'manage_staff',
                'edit_timetable'
            ],
            'Deputy Principal' => [
                'view_reports',
                'approve_exams',
                'manage_staff'
            ],
            'Director of Studies' => [
                'manage_exams',
                'view_student_performance',
                'edit_timetable'
            ],
            'Timetable Master' => [
                'edit_timetable',
                'assign_subjects'
            ],
            'Head of Department' => [
                'manage_subject_teachers',
                'approve_exam_papers',
                'view_subject_reports'
            ],
            'Class Teacher' => [
                'view_class_students',
                'edit_student_records',
                'manage_class_discipline'
            ],
            'Subject Teacher' => [
                'add_grades',
                'edit_exam_papers',
                'view_subject_students'
            ],
            'Guidance & Counseling' => [
                'access_student_discipline',
                'provide_guidance'
            ],
            'Accountant' => [
                'manage_fees',
                'view_financial_reports',
                'manage_payroll'
            ],
            'Librarian' => [
                'manage_library',
                'issue_books',
                'track_library_fines'
            ],
            'Lab Technician' => [
                'manage_lab_equipment',
                'track_experiment_requests'
            ],
            'ICT Admin' => [
                'manage_erp_settings',
                'reset_user_passwords'
            ],
            'School Nurse' => [
                'access_medical_records',
                'manage_student_health'
            ],
            'Receptionist' => [
                'manage_visitors',
                'answer_calls'
            ],
            'Transport Manager' => [
                'manage_transport_routes',
                'assign_drivers'
            ],
            'Security Officer' => [
                'monitor_security',
                'manage_gate_access'
            ],
            'Parent' => [
                'view_student_attendance',
                'view_student_grades',
                'view_student_timetable',
                'view_student_discipline',
                'receive_notifications'
            ],
            'Student' => [
                'view_own_timetable',
                'view_own_grades',
                'view_own_attendance',
                'submit_assignments',
                'view_own_discipline'
            ],
            'Boarding Master/Mistress' => [
                'manage_boarding_students',
                'manage_boarding_facilities',
                'view_boarding_reports'
            ],
            'Sports Coordinator' => [
                'manage_sports_activities',
                'manage_sports_equipment',
                'view_sports_reports'
            ],
            'Examinations Officer' => [
                'manage_exam_schedules',
                'manage_exam_results',
                'view_exam_reports'
            ],
            'Curriculum Developer' => [
                'manage_curriculum',
                'edit_curriculum_content',
                'view_curriculum_reports'
            ]
        ];

        foreach ($roles as $role => $rolePermissions) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);
            $roleInstance->syncPermissions($rolePermissions);
        }
    }
}
