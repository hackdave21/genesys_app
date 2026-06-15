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
        
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = Storage::url($videoPath);
            $data['embed_url'] = Storage::url($videoPath);
        }

        // Thumbnail upload or default by category
        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $thumbnailUrl = Storage::url($path);
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

        if ($request->hasFile('video_file')) {
            // Delete old file if local
            if ($video->video_url && !str_starts_with($video->video_url, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $video->video_url));
            }
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = Storage::url($videoPath);
            $data['embed_url'] = Storage::url($videoPath);
        }

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
        // Delete old local thumbnail if any
        if ($video->thumbnail_url && !str_starts_with($video->thumbnail_url, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $video->thumbnail_url));
        }

        // Delete old local video if any
        if ($video->video_url && !str_starts_with($video->video_url, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $video->video_url));
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Vidéo supprimée avec succès.');
    }
}
