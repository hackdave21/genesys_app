<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the index/home page.
     */
    public function index()
    {
        // Get published testimonials
        $testimonials = Testimonial::where('status', 'published')->latest()->take(6)->get();
        
        // Get featured visible videos
        $featuredVideos = Video::where('status', 'visible')->where('is_featured', true)->latest()->take(3)->get();

        return view('public.index', compact('testimonials', 'featuredVideos'));
    }

    /**
     * Display the portfolio page.
     */
    public function portfolio(Request $request)
    {
        $category = $request->query('category');
        
        $query = Video::where('status', 'visible');
        
        if ($category && in_array($category, ['Publicité', 'Événement', 'Reels', 'Corporate'])) {
            $query->where('category', $category);
        }

        $videos = $query->latest()->get();

        return view('public.portfolio', compact('videos', 'category'));
    }

    /**
     * Display the services page.
     */
    public function services()
    {
        return view('public.services');
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Display the contact page (Quote request form).
     */
    public function contact()
    {
        return view('public.contact');
    }
}
