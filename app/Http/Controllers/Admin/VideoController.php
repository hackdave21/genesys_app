<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Models\Video;
use App\Services\VideoUrlParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of video portfolio items.
     */
    public function index(Request $request)
    {
        $query = Video::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && in_array($request->category, ['Publicité', 'Événement', 'Reels', 'Corporate'])) {
            $query->where('category', $request->category);
        }

        $videos = $query->paginate(15);

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();
        
        // Parse embed URL from video URL
        $embedUrl = VideoUrlParser::parse($data['video_url']);
        if (!$embedUrl) {
            return back()->withErrors(['video_url' => 'L\'URL de la vidéo doit provenir de YouTube ou Vimeo et être valide.'])->withInput();
        }
        $data['embed_url'] = $embedUrl;

        // Auto-detect YouTube thumbnail if none uploaded
        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $thumbnailUrl = Storage::url($path);
        } else {
            // Suggest default by YouTube ID
            $youtubePattern = '%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i';
            if (preg_match($youtubePattern, $data['video_url'], $match)) {
                $thumbnailUrl = 'https://img.youtube.com/vi/' . $match[1] . '/maxresdefault.jpg';
            } else {
                // Fallback by category
                $categoryThumbnails = [
                    'Publicité' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=600&auto=format&fit=crop',
                    'Événement' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&auto=format&fit=crop',
                    'Reels'     => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&auto=format&fit=crop',
                    'Corporate' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=600&auto=format&fit=crop'
                ];
                $thumbnailUrl = $categoryThumbnails[$data['category']];
            }
        }
        $data['thumbnail_url'] = $thumbnailUrl;
        $data['is_featured'] = $request->boolean('is_featured', false);

        Video::create($data);

        return redirect()->route('admin.videos.index')->with('success', 'Vidéo ajoutée au portfolio avec succès !');
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(StoreVideoRequest $request, Video $video)
    {
        $data = $request->validated();

        $embedUrl = VideoUrlParser::parse($data['video_url']);
        if (!$embedUrl) {
            return back()->withErrors(['video_url' => 'L\'URL de la vidéo doit provenir de YouTube ou Vimeo et être valide.'])->withInput();
        }
        $data['embed_url'] = $embedUrl;

        if ($request->hasFile('thumbnail')) {
            // Delete old file if local
            if ($video->thumbnail_url && !str_starts_with($video->thumbnail_url, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $video->thumbnail_url));
            }
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail_url'] = Storage::url($path);
        }

        $data['is_featured'] = $request->boolean('is_featured', false);

        $video->update($data);

        return redirect()->route('admin.videos.index')->with('success', 'Vidéo mise à jour avec succès !');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video)
    {
        // Delete old local file if any
        if ($video->thumbnail_url && !str_starts_with($video->thumbnail_url, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $video->thumbnail_url));
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Vidéo supprimée avec succès.');
    }
}
