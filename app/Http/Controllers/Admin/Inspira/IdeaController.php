<?php

namespace App\Http\Controllers\Admin\Inspira;

use App\Http\Controllers\Controller;
use App\Models\ContentIdea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = ContentIdea::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $ideas = $query->latest()->paginate(20);

        return view('admin.inspira.ideas.index', compact('ideas'));
    }
}
