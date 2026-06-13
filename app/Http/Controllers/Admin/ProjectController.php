<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display the projects Kanban board or list view.
     */
    public function index(Request $request)
    {
        $view = $request->query('view', 'kanban'); // kanban or list
        
        $projects = Project::with(['client', 'quote'])->latest()->get();
        $clients = User::where('role', 'client')->get();

        return view('admin.projets.index', compact('projects', 'view', 'clients'));
    }

    /**
     * Store a new project manually.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'client_id' => 'nullable|exists:users,id',
            'priority'  => 'required|in:Bas,Moyen,Urgent',
            'team'      => 'nullable|array',
            'deadline'  => 'nullable|date',
        ]);

        Project::create([
            'title'     => $request->title,
            'client_id' => $request->client_id,
            'progress'  => 0,
            'step'      => 'Scripting',
            'priority'  => $request->priority,
            'team'      => $request->team ?: ['TA'],
            'deadline'  => $request->deadline,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Nouveau projet créé avec succès.');
    }

    /**
     * Update the project step (via dropdown or drag & drop).
     */
    public function updateStep(Request $request, Project $project)
    {
        $request->validate([
            'step' => 'required|in:Scripting,Tournage,Montage,Terminé',
        ]);

        $project->update([
            'step' => $request->step,
            // If moved to Terminé, progress automatically becomes 100%
            'progress' => $request->step === 'Terminé' ? 100 : $project->progress,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'project' => $project]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Étape du projet mise à jour.');
    }

    /**
     * Update project progress and priority.
     */
    public function updateProgress(Request $request, Project $project)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'priority' => 'required|in:Bas,Moyen,Urgent',
            'deadline' => 'nullable|date',
        ]);

        $project->update([
            'progress' => $request->progress,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            // If progress hits 100%, step should automatically move to Terminé
            'step'     => $request->progress == 100 ? 'Terminé' : $project->step,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Informations du projet mises à jour.');
    }

    /**
     * Delete a project card.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Projet supprimé.');
    }
}
