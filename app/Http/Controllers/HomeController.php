<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\NewsArticle;
use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Member;
use App\Models\BannerImage;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $bannerImages = BannerImage::where('is_active', true)->orderBy('sort_order')->get();

        $fallbackImages = [];
        $clubImgPath = public_path('images/club');
        if (File::isDirectory($clubImgPath)) {
            $files = File::files($clubImgPath);
            $fallbackImages = collect($files)
                ->filter(fn($f) => in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                ->take(5)
                ->map(fn($f) => $f->getFilename())
                ->values()
                ->toArray();
        }

        $notices = Notice::where('is_published', true)->orderByDesc('published_at')->take(5)->get();
        $latestNews = NewsArticle::where('is_published', true)->orderByDesc('published_at')->take(5)->get();
        $upcomingEvents = Event::where('is_published', true)->where('event_date', '>', now()->toDateString())->orderBy('event_date')->take(5)->get();
        $executives = Member::where('is_published', true)->where('type', 'executive')->orderBy('sort_order')->take(8)->get();
        $galleryPhotos = GalleryPhoto::where('is_published', true)->orderByDesc('created_at')->take(8)->get();

        return view('home', compact('bannerImages', 'fallbackImages', 'notices', 'latestNews', 'upcomingEvents', 'executives', 'galleryPhotos'));
    }
}