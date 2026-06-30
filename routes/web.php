<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsletterController;

// Language switcher
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'bn'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');

Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{slug}', [NoticeController::class, 'show'])->name('notices.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');

// Hall Booking
Route::get('/book-hall', [BookingController::class, 'index'])->name('booking.form');
Route::post('/book-hall', [BookingController::class, 'store'])->name('booking.store');
Route::get('/book-hall/availability', [BookingController::class, 'checkAvailability'])->name('booking.availability');
Route::get('/book-hall/confirm/{ref}', [BookingController::class, 'confirm'])->name('booking.confirm');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

Route::get('/storage-debug', function() {
    $link = public_path('storage');
    $target = storage_path('app/public');
    
    $out = [];
    $out['link_path'] = $link;
    $out['target_path'] = $target;
    $out['link_exists'] = file_exists($link) ? 'YES' : 'NO';
    $out['link_is_link'] = is_link($link) ? 'YES' : 'NO';
    $out['link_is_dir'] = is_dir($link) ? 'YES' : 'NO';
    if (is_link($link)) {
        $out['link_target'] = readlink($link);
    }
    
    // Check if target directory exists and is writeable
    $out['target_exists'] = file_exists($target) ? 'YES' : 'NO';
    $out['target_is_dir'] = is_dir($target) ? 'YES' : 'NO';
    $out['target_writeable'] = is_writable($target) ? 'YES' : 'NO';
    $out['link_parent_writeable'] = is_writable(dirname($link)) ? 'YES' : 'NO';
    
    // Check if member directory exists and lists files
    $memberDir = $target . '/members';
    if (file_exists($memberDir)) {
        $files = scandir($memberDir);
        $out['member_files'] = array_slice($files, 0, 10);
    } else {
        $out['member_files_error'] = "members dir does not exist";
    }
    
    // Force link deletion and regeneration
    try {
        if (is_link($link) || file_exists($link) || is_dir($link)) {
            $out['delete_action'] = unlink($link) ? 'SUCCESS' : 'FAILED';
        }
        
        $artisanRes = \Illuminate\Support\Facades\Artisan::call('storage:link');
        $out['artisan_output'] = \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        $out['error'] = $e->getMessage();
    }
    
    $out['new_link_exists'] = file_exists($link) ? 'YES' : 'NO';
    $out['new_link_is_link'] = is_link($link) ? 'YES' : 'NO';
    if (is_link($link)) {
        $out['new_link_target'] = readlink($link);
    }
    
    return response()->json($out);
});


