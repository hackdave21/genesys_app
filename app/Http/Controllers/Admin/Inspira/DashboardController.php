<?php

namespace App\Http\Controllers\Admin\Inspira;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $activeSubscribers = Subscription::where('status', 'active')
            ->where('expires_at', '>', now())->count();

        $totalRevenue = Payment::where('status', 'accepted')->sum('amount');

        $monthRevenue = Payment::where('status', 'accepted')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $expiredCount = Subscription::where('status', 'expired')->count();
        $renewedCount = Subscription::where('status', 'active')
            ->whereNotNull('started_at')
            ->where('created_at', '<', DB::raw('started_at'))
            ->count();

        $renewalRate = $expiredCount > 0
            ? round(($renewedCount / ($expiredCount + $renewedCount)) * 100, 1)
            : 0;

        $monthlySignups = Subscription::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get();

        return view('admin.inspira.dashboard', compact(
            'activeSubscribers',
            'totalRevenue',
            'monthRevenue',
            'renewalRate',
            'monthlySignups',
        ));
    }
}
