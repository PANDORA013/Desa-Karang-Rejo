<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\VillageData;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page)
    {
        // Check if page is published
        if ($page->status !== 'published') {
            abort(404, 'Halaman tidak ditemukan atau belum dipublikasi.');
        }

        $data = [];
        
        // Load additional data based on page template
        switch ($page->template) {
            case 'profile':
                $data['demographics'] = VillageData::byType('demografi')->ordered()->get();
                $data['geography'] = VillageData::byType('geografis')->ordered()->get();
                $data['economy'] = VillageData::byType('ekonomi')->ordered()->get();
                break;
                
            case 'organization':
                $data['officials'] = User::active()->byRole('operator')->get();
                break;
                
            // case 'services':
            //     // Add services data if needed
            //     break;
        }

        return view('frontend.pages.show', compact('page') + $data);
    }

    public function profile()
    {
        $demographics = VillageData::byType('demografi')->ordered()->get();
        $geography = VillageData::byType('geografis')->ordered()->get();
        $economy = VillageData::byType('ekonomi')->ordered()->get();
        $education = VillageData::byType('pendidikan')->ordered()->get();
        $health = VillageData::byType('kesehatan')->ordered()->get();

        return view('frontend.pages.profile', compact(
            'demographics', 
            'geography', 
            'economy', 
            'education', 
            'health'
        ));
    }

    public function organization()
    {
        $officials = User::active()
            ->whereIn('role', ['admin', 'operator'])
            ->orderBy('role', 'desc')
            ->orderBy('name')
            ->get();

        return view('frontend.pages.organization', compact('officials'));
    }

    // public function services()
    // {
    //     return view('frontend.pages.services');
    // }

    public function history()
    {
        $page = Page::published()
            ->where('slug', 'sejarah')
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }

    public function visionMission()
    {
        $page = Page::published()
            ->where('slug', 'visi-misi')
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}