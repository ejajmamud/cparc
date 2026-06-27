<?php
namespace App\Http\Controllers;
use App\Models\Notice;
use App\Models\Event;
class NoticeController extends Controller {
    public function index() {
        $query = Notice::where('is_published', true)->orderByDesc('published_at');
        if (request('type')) { $query->where('type', request('type')); }
        $notices = $query->paginate(10);
        $recentEvents = Event::where('is_published', true)->orderByDesc('event_date')->take(5)->get();
        return view('notices.index', compact('notices', 'recentEvents'));
    }
    public function show(string $slug) {
        $notice = Notice::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $recentNotices = Notice::where('is_published', true)->where('id', '!=', $notice->id)->orderByDesc('published_at')->take(5)->get();
        return view('notices.show', compact('notice', 'recentNotices'));
    }
}