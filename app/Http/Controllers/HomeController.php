<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\NewsArticle;
use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Member;
use App\Models\BannerImage;
use App\Models\Package;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $bannerImages = BannerImage::where('is_active', true)->orderBy('sort_order')->get();

        // Use actual club slide images for hero slider
        $fallbackImages = [];
        if ($bannerImages->isEmpty()) {
            $clubImgPath = public_path('images/club');
            if (File::isDirectory($clubImgPath)) {
                $fallbackImages = collect(File::files($clubImgPath))
                    ->filter(fn($f) => str_starts_with($f->getFilename(), 'slide_')
                        && in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'webp']))
                    ->sortBy(fn($f) => (int) filter_var($f->getFilename(), FILTER_SANITIZE_NUMBER_INT))
                    ->take(10)
                    ->map(fn($f) => $f->getFilename())
                    ->values()
                    ->toArray();
            }
        }

        $notices       = Notice::where('is_published', true)->orderByDesc('published_at')->take(5)->get();
        $latestNews    = NewsArticle::where('is_published', true)->orderByDesc('published_at')->take(5)->get();
        $upcomingEvents = Event::where('is_published', true)
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')->take(5)->get();
        $executives    = Member::where('is_published', true)->where('type', 'executive')->orderBy('sort_order')->take(8)->get();
        $galleryPhotos = GalleryPhoto::where('is_published', true)->orderByDesc('created_at')->take(6)->get();
        $packages      = Package::where('is_active', true)->orderBy('sort_order')->get();

        return view('home', compact(
            'bannerImages', 'fallbackImages', 'notices', 'latestNews',
            'upcomingEvents', 'executives', 'galleryPhotos', 'packages'
        ));
    }
}
