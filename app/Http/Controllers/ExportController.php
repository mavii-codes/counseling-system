<?php

namespace App\Http\Controllers;

use App\Models\CounselingCase;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * CSV export of students (additional feature).
     */
    public function students(): StreamedResponse
    {
        $filename = 'students-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Student #', 'Name', 'Email', 'Phone', 'Program', 'Year', 'Created']);

            Student::orderBy('name')->chunk(200, function ($students) use ($handle): void {
                foreach ($students as $s) {
                    fputcsv($handle, [
                        $s->student_number,
                        $s->name,
                        $s->email,
                        $s->phone,
                        $s->program,
                        $s->year_level,
                        $s->created_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * CSV export of counseling cases with filters (additional feature).
     */
    public function cases(Request $request): StreamedResponse
    {
        $filename = 'counseling-cases-'.now()->format('Y-m-d-His').'.csv';

        $query = CounselingCase::query()->with(['student', 'counselor'])->orderByDesc('opened_at');

        if ($cat = $request->get('category')) {
            $query->where('category', $cat);
        }

        if ($st = $request->get('status')) {
            $query->where('status', $st);
        }

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Student', 'Student #', 'Category', 'Status', 'Counselor', 'Opened', 'Closed']);

            $query->chunk(200, function ($cases) use ($handle): void {
                foreach ($cases as $c) {
                    fputcsv($handle, [
                        $c->id,
                        $c->title,
                        $c->student?->name,
                        $c->student?->student_number,
                        $c->category,
                        $c->status,
                        $c->counselor?->name,
                        $c->opened_at?->toDateTimeString(),
                        $c->closed_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
