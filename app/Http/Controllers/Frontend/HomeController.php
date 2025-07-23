<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\VillageData;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Post::published()
            ->with(['category', 'user'])
            ->latest()
            ->limit(6)
            ->get();

        $announcements = Announcement::active()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $galleries = Gallery::active()
            ->byType('photo')
            ->latest()
            ->limit(8)
            ->get();

        $villageStats = VillageData::byType('demografi')
            ->ordered()
            ->get();

        return view('frontend.home', compact(
            'latestPosts', 
            'announcements', 
            'galleries', 
            'villageStats'
        ));
    }
}