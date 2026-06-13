<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of registered client users.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'client')->withCount(['quotes', 'projects']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['active', 'suspended'])) {
            $query->where('status', $request->status);
        }

        $clients = $query->latest()->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Display details of a specific client, with their history.
     */
    public function show(User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }

        $client->load(['quotes', 'projects']);

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Toggle the active status of a client account (Activate / Suspend).
     */
    public function toggleStatus(User $client)
    {
        if ($client->role !== 'client') {
            return back()->withErrors(['error' => 'Action non autorisée.']);
        }

        $newStatus = $client->status === 'active' ? 'suspended' : 'active';
        $client->update(['status' => $newStatus]);

        $message = $newStatus === 'active' 
            ? 'Le compte du client a été réactivé.' 
            : 'Le compte du client a été suspendu.';

        return redirect()->route('admin.clients.index')->with('success', $message);
    }
}
