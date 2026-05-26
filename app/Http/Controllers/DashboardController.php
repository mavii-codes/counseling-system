<?php

namespace App\Http\Controllers;

use App\Models\CounselingCase;
use App\Models\CounselingSession;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $categoryCounts = CounselingCase::query()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category');

        $statusCounts = CounselingCase::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $upcomingSessions = CounselingSession::query()
            ->with(['counselingCase.student'])
            ->where('session_at', '>=', now()->startOfDay())
            ->where('session_at', '<=', now()->addDays(14))
            ->orderBy('session_at')
            ->limit(6)
            ->get();

        $recentSessions = CounselingSession::query()
            ->with(['counselingCase.student'])
            ->orderByDesc('session_at')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'totalCases' => CounselingCase::count(),
            'categoryCounts' => $categoryCounts,
            'statusCounts' => $statusCounts,
            'upcomingSessions' => $upcomingSessions,
            'recentSessions' => $recentSessions,
        ]);
    }
}
