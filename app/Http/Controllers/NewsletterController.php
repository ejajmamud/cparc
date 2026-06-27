<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'name'  => 'nullable|string|max:100',
        ]);

        $exists = NewsletterSubscriber::where('email', $request->email)->exists();

        if (!$exists) {
            NewsletterSubscriber::create([
                'email'  => $request->email,
                'name'   => $request->name,
                'locale' => app()->getLocale(),
                'status' => 'active',
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() === 'bn'
                    ? 'সফলভাবে সাবস্ক্রাইব করা হয়েছে!'
                    : 'Successfully subscribed!',
            ]);
        }

        return back()->with('newsletter_success',
            app()->getLocale() === 'bn'
                ? 'সফলভাবে সাবস্ক্রাইব করা হয়েছে!'
                : 'Successfully subscribed!'
        );
    }
}
