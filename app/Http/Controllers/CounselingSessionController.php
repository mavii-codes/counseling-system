<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCounselingSessionRequest;
use App\Http\Requests\UpdateCounselingSessionRequest;
use App\Models\CounselingCase;
use App\Models\CounselingSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CounselingSessionController extends Controller
{
    /**
     * All sessions (global history list).
     */
    public function timeline(Request $request): View
    {
        $query = CounselingSession::query()
            ->with(['counselingCase.student', 'counselingCase.counselor'])
            ->orderByDesc('session_at');

        if ($caseId = $request->get('case_id')) {
            $query->where('counseling_case_id', $caseId);
        }

        if ($q = trim((string) $request->get('q', ''))) {
            $like = '%'.$q.'%';
            $query->where(function ($sub) use ($like) {
                $sub->where('notes', 'like', $like)
                    ->orWhere('next_steps', 'like', $like)
                    ->orWhereHas('counselingCase', function ($c) use ($like) {
                        $c->where('title', 'like', $like);
                    })
                    ->orWhereHas('counselingCase.student', function ($s) use ($like) {
                        $s->where('name', 'like', $like);
                    });
            });
        }

        $sessions = $query->paginate(20)->withQueryString();

        return view('sessions.timeline', compact('sessions'));
    }

    public function index(CounselingCase $counseling_case): View
    {
        $sessions = $counseling_case->counselingSessions()
            ->orderByDesc('session_at')
            ->paginate(15);

        return view('sessions.index', [
            'case' => $counseling_case,
            'sessions' => $sessions,
        ]);
    }

    public function create(CounselingCase $counseling_case): View
    {
        return view('sessions.create', ['case' => $counseling_case]);
    }

    public function store(StoreCounselingSessionRequest $request, CounselingCase $counseling_case): RedirectResponse
    {
        $counseling_case->counselingSessions()->create($request->validated());

        return redirect()
            ->route('counseling-cases.show', $counseling_case)
            ->with('success', 'Session logged.');
    }

    public function show(CounselingCase $counseling_case, CounselingSession $session): View
    {
        abort_unless($session->counseling_case_id === $counseling_case->id, 404);

        return view('sessions.show', ['case' => $counseling_case, 'session' => $session]);
    }

    public function edit(CounselingCase $counseling_case, CounselingSession $session): View
    {
        abort_unless($session->counseling_case_id === $counseling_case->id, 404);

        return view('sessions.edit', ['case' => $counseling_case, 'session' => $session]);
    }

    public function update(
        UpdateCounselingSessionRequest $request,
        CounselingCase $counseling_case,
        CounselingSession $session
    ): RedirectResponse {
        abort_unless($session->counseling_case_id === $counseling_case->id, 404);

        $session->update($request->validated());

        return redirect()
            ->route('counseling-cases.show', $counseling_case)
            ->with('success', 'Session updated.');
    }

    public function destroy(CounselingCase $counseling_case, CounselingSession $session): RedirectResponse
    {
        abort_unless($session->counseling_case_id === $counseling_case->id, 404);

        $session->delete();

        return redirect()
            ->route('counseling-cases.show', $counseling_case)
            ->with('success', 'Session removed.');
    }
}
