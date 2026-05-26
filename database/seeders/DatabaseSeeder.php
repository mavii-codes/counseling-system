<?php

namespace Database\Seeders;

use App\Models\CounselingCase;
use App\Models\CounselingSession;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $counselor = User::query()->firstOrCreate(
            ['email' => 'counselor@atelier.local'],
            [
                'name' => 'Dr. Mara Chen',
                'password' => Hash::make('password'),
            ]
        );

        $s1 = Student::query()->create([
            'student_number' => '2024-0142',
            'name' => 'Jordan Reyes',
            'email' => 'j.reyes@campus.edu',
            'phone' => '555-0101',
            'program' => 'BS Computer Science',
            'year_level' => '3rd year',
            'notes' => 'Prefers morning appointments.',
        ]);

        $s2 = Student::query()->create([
            'student_number' => '2023-0088',
            'name' => 'Sam Dela Cruz',
            'email' => 's.delacruz@campus.edu',
            'phone' => '555-0102',
            'program' => 'BA Psychology',
            'year_level' => '4th year',
            'notes' => null,
        ]);

        $case1 = CounselingCase::query()->create([
            'student_id' => $s1->id,
            'counselor_id' => $counselor->id,
            'title' => 'Academic overload & time management',
            'category' => CounselingCase::CATEGORY_ACADEMIC,
            'status' => CounselingCase::STATUS_ACTIVE,
            'summary' => 'Student reported declining grades in data structures; seeking structured study plan.',
            'opened_at' => now()->subWeeks(3),
        ]);

        $case2 = CounselingCase::query()->create([
            'student_id' => $s2->id,
            'counselor_id' => $counselor->id,
            'title' => 'Homesickness & adjustment',
            'category' => CounselingCase::CATEGORY_PERSONAL,
            'status' => CounselingCase::STATUS_OPEN,
            'summary' => 'First-gen student navigating family expectations away from home.',
            'opened_at' => now()->subDays(10),
        ]);

        CounselingSession::query()->create([
            'counseling_case_id' => $case1->id,
            'session_at' => now()->subWeeks(3),
            'duration_minutes' => 45,
            'notes' => "Initial intake: mapped current course load (18 units). Discussed Pomodoro pacing and professor office hours. Student agreed to weekly study block calendar.",
            'next_steps' => 'Email prof for extensions on lab 3; bring draft calendar next visit.',
        ]);

        CounselingSession::query()->create([
            'counseling_case_id' => $case1->id,
            'session_at' => now()->subWeek(),
            'duration_minutes' => 30,
            'notes' => 'Follow-up: grades stabilized in two courses. Stress peaks before midterms — practiced breathing exercise.',
            'next_steps' => 'Peer tutoring for algorithms; revisit if insomnia returns.',
        ]);

        CounselingSession::query()->create([
            'counseling_case_id' => $case2->id,
            'session_at' => now()->subDays(5)->setTime(14, 0),
            'duration_minutes' => 50,
            'notes' => 'Explored family communication patterns. Identified one trusted relative for weekly check-ins.',
            'next_steps' => 'Join campus peer support circle; journal three good things daily.',
        ]);

        CounselingSession::query()->create([
            'counseling_case_id' => $case2->id,
            'session_at' => now()->addDays(2)->setTime(10, 30),
            'duration_minutes' => 45,
            'notes' => 'Scheduled follow-up regarding adjustment to dorm life.',
            'next_steps' => null,
        ]);
    }
}
