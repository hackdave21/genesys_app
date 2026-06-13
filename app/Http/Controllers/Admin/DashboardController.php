<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Quote;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the administration dashboard.
     */
    public function index()
    {
        $metrics = [
            'total_quotes'     => Quote::count(),
            'new_quotes'       => Quote::where('status', 'Nouveau')->count(),
            'active_projects'  => Project::where('step', '!=', 'Terminé')->count(),
            'total_clients'    => User::where('role', 'client')->count(),
        ];

        // Count projects by step
        $projectsByStep = [
            'Scripting' => Project::where('step', 'Scripting')->count(),
            'Tournage'  => Project::where('step', 'Tournage')->count(),
            'Montage'   => Project::where('step', 'Montage')->count(),
            'Terminé'   => Project::where('step', 'Terminé')->count(),
        ];

        // Get recent quotes
        $recentQuotes = Quote::latest()->take(5)->get();

        return view('admin.dashboard', compact('metrics', 'projectsByStep', 'recentQuotes'));
    }
}
