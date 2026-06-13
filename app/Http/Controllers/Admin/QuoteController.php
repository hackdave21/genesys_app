<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of quote requests.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = Quote::latest();
        
        if ($status && in_array($status, ['Nouveau', 'Envoyé', 'Accepté', 'Refusé'])) {
            $query->where('status', $status);
        }

        $quotes = $query->paginate(15);
        
        $counts = [
            'all'      => Quote::count(),
            'Nouveau'  => Quote::where('status', 'Nouveau')->count(),
            'Envoyé'   => Quote::where('status', 'Envoyé')->count(),
            'Accepté'  => Quote::where('status', 'Accepté')->count(),
            'Refusé'   => Quote::where('status', 'Refusé')->count(),
        ];

        return view('admin.devis.index', compact('quotes', 'counts', 'status'));
    }

    /**
     * Update the status of a quote request.
     */
    public function updateStatus(Request $request, Quote $quote)
    {
        $request->validate([
            'status' => 'required|in:Nouveau,Envoyé,Accepté,Refusé',
        ]);

        $oldStatus = $quote->status;
        $newStatus = $request->status;

        $quote->update(['status' => $newStatus]);

        // Auto-create Kanban Project if quote is Accepted and doesn't already have a project
        if ($newStatus === 'Accepté' && $oldStatus !== 'Accepté') {
            $existingProject = Project::where('quote_id', $quote->id)->first();
            
            if (!$existingProject) {
                Project::create([
                    'title'     => ($quote->company ?: $quote->client_name) . ' - ' . $quote->project_type,
                    'quote_id'  => $quote->id,
                    'client_id' => $quote->user_id,
                    'progress'  => 0,
                    'step'      => 'Scripting',
                    'priority'  => 'Moyen',
                    'team'      => ['TA'], // Thierry Amenyah by default
                    'deadline'  => now()->addDays(30)->toDateString(),
                ]);
            }
        }

        return redirect()->route('admin.devis.index')->with('success', 'Statut du devis mis à jour avec succès.');
    }
}
