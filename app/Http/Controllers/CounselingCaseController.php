<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCounselingCaseRequest;
use App\Http\Requests\UpdateCounselingCaseRequest;
use App\Models\CounselingCase;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CounselingCaseController extends Controller
{
    public function index(Request $request): View
    {
        $query = CounselingCase::query()
            ->with(['student', 'counselor'])
            ->orderByDesc('opened_at');

        if ($cat = $request->get('category')) {
            $query->where('category', $cat);
        }

        if ($st = $request->get('status')) {
            $query->where('status', $st);
        }

        if ($q = trim((string) $request->get('q', ''))) {
            $like = '%'.$q.'%';
            $query->where(function ($sub) use ($like) {
                $sub->where('title', 'like', $like)
                    ->orWhereHas('student', function ($s) use ($like) {
                        $s->where('name', 'like', $like)
                            ->orWhere('student_number', 'like', $like);
                    });
            });
        }

        $cases = $query->paginate(15)->withQueryString();

        return view('counseling-cases.index', compact('cases'));
    }

    public function create(Request $request): View
    {
        $students = Student::orderBy('name')->get();
        $selectedStudentId = $request->get('student_id');

        return view('counseling-cases.create', compact('students', 'selectedStudentId'));
    }

    public function store(StoreCounselingCaseRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['counselor_id'] = $request->user()->id;

        if (! empty($data['opened_at'])) {
            $data['opened_at'] = \Carbon\Carbon::parse($data['opened_at']);
        } else {
            $data['opened_at'] = now();
        }

        $case = CounselingCase::create($data);
        $this->syncClosedAt($case);

        return redirect()->route('counseling-cases.show', $case)->with('success', 'Case opened.');
    }

    public function show(CounselingCase $counseling_case): View
    {
        $counseling_case->load([
            'student',
            'counselor',
            'counselingSessions' => fn ($q) => $q->orderByDesc('session_at'),
        ]);

        return view('counseling-cases.show', ['case' => $counseling_case]);
    }

    public function edit(CounselingCase $counseling_case): View
    {
        $students = Student::orderBy('name')->get();

        return view('counseling-cases.edit', ['case' => $counseling_case, 'students' => $students]);
    }

    public function update(UpdateCounselingCaseRequest $request, CounselingCase $counseling_case): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['opened_at']) && $data['opened_at']) {
            $data['opened_at'] = \Carbon\Carbon::parse($data['opened_at']);
        }

        if (isset($data['closed_at']) && $data['closed_at']) {
            $data['closed_at'] = \Carbon\Carbon::parse($data['closed_at']);
        }

        $counseling_case->update($data);
        $this->syncClosedAt($counseling_case->fresh());

        return redirect()->route('counseling-cases.show', $counseling_case)->with('success', 'Case updated.');
    }

    public function destroy(CounselingCase $counseling_case): RedirectResponse
    {
        $counseling_case->delete();

        return redirect()->route('counseling-cases.index')->with('success', 'Case deleted.');
    }

    /**
     * Printable / summary view (additional feature: print-friendly report).
     */
    public function report(CounselingCase $counseling_case): View
    {
        $counseling_case->load([
            'student',
            'counselor',
            'counselingSessions' => fn ($q) => $q->orderBy('session_at'),
        ]);

        return view('counseling-cases.report', ['case' => $counseling_case]);
    }

    private function syncClosedAt(CounselingCase $case): void
    {
        if (in_array($case->status, [CounselingCase::STATUS_CLOSED, CounselingCase::STATUS_RESOLVED], true) && ! $case->closed_at) {
            $case->update(['closed_at' => now()]);
        }

        if (! in_array($case->status, [CounselingCase::STATUS_CLOSED, CounselingCase::STATUS_RESOLVED], true) && $case->closed_at) {
            $case->update(['closed_at' => null]);
        }
    }
}
