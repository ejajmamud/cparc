<?php
namespace App\Http\Controllers;
use App\Models\GalleryPhoto;
use App\Models\GalleryAlbum;
class GalleryController extends Controller {
    public function index() {
        $albums = GalleryAlbum::where('is_published', true)->orderBy('name')->get();
        $query = GalleryPhoto::where('is_published', true)->orderBy('sort_order')->orderByDesc('created_at');
        if (request('album')) { $query->where('gallery_album_id', request('album')); }
        $photos = $query->paginate(16);
        return view('gallery.index', compact('albums', 'photos'));
    }
}