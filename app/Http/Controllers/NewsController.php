<?php
namespace App\Http\Controllers;
use App\Models\NewsArticle;
class NewsController extends Controller {
    public function index() {
        $news = NewsArticle::where('is_published', true)->orderByDesc('published_at')->paginate(9);
        return view('news.index', compact('news'));
    }
    public function show(string $slug) {
        $article = NewsArticle::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $recentNews = NewsArticle::where('is_published', true)->where('id', '!=', $article->id)->orderByDesc('published_at')->take(5)->get();
        return view('news.show', compact('article', 'recentNews'));
    }
}