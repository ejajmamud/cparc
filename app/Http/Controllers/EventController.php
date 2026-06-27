<?php
namespace App\Http\Controllers;
use App\Models\Event;
class EventController extends Controller {
    public function index() {
        $query = Event::where('is_published', true);
        if (request('type') === 'upcoming') { $query->where('event_date', '>=', now()->toDateString())->orderBy('event_date'); }
        elseif (request('type') === 'past') { $query->where('event_date', '<', now()->toDateString())->orderByDesc('event_date'); }
        else { $query->orderByDesc('event_date'); }
        $events = $query->paginate(9);
        return view('events.index', compact('events'));
    }
    public function show(string $slug) {
        $event = Event::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $otherEvents = Event::where('is_published', true)->where('id', '!=', $event->id)->orderByDesc('event_date')->take(5)->get();
        return view('events.show', compact('event', 'otherEvents'));
    }
}