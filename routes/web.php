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
    if (is_link($link)) {
        $out['link_target'] = readlink($link);
    }
    
    // Recursive folder list under /app/storage
    $listDirectory = function($dir, $depth = 0) use (&$listDirectory) {
        if ($depth > 3) return [];
        if (!file_exists($dir) || !is_dir($dir)) return [];
        
        $files = scandir($dir);
        $res = [];
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                $res[$file] = $listDirectory($path, $depth + 1);
            } else {
                $res[] = $file . ' (' . filesize($path) . ' bytes)';
            }
        }
        return $res;
    };
    
    $out['app_storage_contents'] = $listDirectory(storage_path());
    $out['public_dir_contents'] = scandir(public_path());
    
    // Read last 50 lines of laravel.log
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $out['laravel_log'] = array_slice($lines, -50);
    } else {
        $out['laravel_log'] = "no log file found";
    }
    
    return response()->json($out);
});

Route::get('/extract-storage', function() {
    $zipPath = base_path('storage.zip');
    $extractPath = storage_path('app/public');
    
    if (!file_exists($zipPath)) {
        return response()->json(['error' => 'storage.zip not found in base path: ' . $zipPath]);
    }
    
    $success = false;
    $output = '';
    
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive;
        $res = $zip->open($zipPath);
        if ($res === TRUE) {
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }
            $zip->extractTo($extractPath);
            $zip->close();
            $success = true;
            $output = 'Extracted via ZipArchive';
        } else {
            $output = 'ZipArchive open failed, code: ' . $res;
        }
    }
    
    if (!$success) {
        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0777, true);
        }
        $cmd = "unzip -o " . escapeshellarg($zipPath) . " -d " . escapeshellarg($extractPath) . " 2>&1";
        $shellOut = shell_exec($cmd);
        if (str_contains(strtolower($shellOut), 'extracting') || str_contains(strtolower($shellOut), 'inflating')) {
            $success = true;
            $output = 'Extracted via shell unzip';
        } else {
            return response()->json([
                'error' => 'All extraction methods failed',
                'ziparchive_status' => $output,
                'shell_output' => $shellOut
            ]);
        }
    }
    
    // Convert Windows backslashes in filenames to Linux directory structures
    if (file_exists($extractPath) && is_dir($extractPath)) {
        $files = scandir($extractPath);
        foreach ($files as $file) {
            if (str_contains($file, '\\')) {
                $newPath = str_replace('\\', '/', $file);
                $fullNewPath = $extractPath . '/' . $newPath;
                $fullOldPath = $extractPath . '/' . $file;
                
                $dir = dirname($fullNewPath);
                if (!file_exists($dir)) {
                    @mkdir($dir, 0777, true);
                }
                @rename($fullOldPath, $fullNewPath);
            }
        }
    }
    
    // Change permissions to allow writes
    try {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($extractPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $item) {
            @chmod($item, 0777);
        }
    } catch (\Exception $e) {}
    
    return response()->json(['status' => 'SUCCESS', 'message' => $output]);
});

Route::get('/test-image', function() {
    $path = public_path('storage/members/01KW98AJ0TM4SQB5Q8B7M8ZQJ3.png');
    return response()->json([
        'path' => $path,
        'exists' => file_exists($path) ? 'YES' : 'NO',
        'is_readable' => is_readable($path) ? 'YES' : 'NO',
        'direct_exists' => file_exists(storage_path('app/public/members/01KW98AJ0TM4SQB5Q8B7M8ZQJ3.png')) ? 'YES' : 'NO',
        'direct_path' => storage_path('app/public/members/01KW98AJ0TM4SQB5Q8B7M8ZQJ3.png'),
    ]);
});

Route::get('/fix-paths', function() {
    $dir = storage_path('app/public');
    $log = [];
    if (file_exists($dir) && is_dir($dir)) {
        $files = scandir($dir);
        $log['total_files_scanned'] = count($files);
        $renamed = 0;
        foreach ($files as $file) {
            if (str_contains($file, '\\')) {
                $newPath = str_replace('\\', '/', $file);
                $fullNewPath = $dir . '/' . $newPath;
                $fullOldPath = $dir . '/' . $file;
                
                $parent = dirname($fullNewPath);
                if (!file_exists($parent)) {
                    if (!@mkdir($parent, 0777, true)) {
                        $log['errors'][] = "Failed to create directory: " . $parent;
                        continue;
                    }
                }
                if (@rename($fullOldPath, $fullNewPath)) {
                    @chmod($fullNewPath, 0777);
                    $renamed++;
                } else {
                    $log['errors'][] = "Failed to rename: " . $file;
                }
            }
        }
        $log['renamed_count'] = $renamed;
    } else {
        $log['error'] = "Directory does not exist: " . $dir;
    }
    return response()->json($log);
});

Route::get('/log-debug', function() {
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $content = file_get_contents($logFile);
        $pos = strrpos($content, 'local.ERROR:');
        if ($pos !== false) {
            return response(substr($content, $pos, 2000))->header('Content-Type', 'text/plain');
        }
        return "local.ERROR not found in logs. Total size: " . strlen($content);
    }
    return "No log file";
});

Route::get('/test-zip', function() {
    $zipPath = base_path('storage.zip');
    return response()->json([
        'zip_path' => $zipPath,
        'zip_exists' => file_exists($zipPath) ? 'YES' : 'NO',
        'zip_size' => file_exists($zipPath) ? filesize($zipPath) : 0,
        'zip_readable' => is_readable($zipPath) ? 'YES' : 'NO',
        'shell_unzip_version' => shell_exec('unzip -v 2>&1'),
    ]);
});

Route::get('/test-write', function() {
    $dir = storage_path('app/public');
    $testFile = $dir . '/test_write.txt';
    $log = [];
    $log['public_path_writeable'] = is_writable(public_path()) ? 'YES' : 'NO';
    $log['storage_path_writeable'] = is_writable(storage_path()) ? 'YES' : 'NO';
    $log['app_path_writeable'] = is_writable(storage_path('app')) ? 'YES' : 'NO';
    
    try {
        if (!file_exists($dir)) {
            $log['mkdir_attempt'] = mkdir($dir, 0777, true) ? 'SUCCESS' : 'FAILED';
        } else {
            $log['dir_exists'] = 'YES';
        }
        $log['file_put_attempt'] = file_put_contents($testFile, 'test') !== false ? 'SUCCESS' : 'FAILED';
        if (file_exists($testFile)) {
            unlink($testFile);
        }
    } catch (\Exception $e) {
        $log['exception'] = $e->getMessage();
    }
    return response()->json($log);
});


