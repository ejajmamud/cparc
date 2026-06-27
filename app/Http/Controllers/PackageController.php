<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->orderBy('sort_order')->get();
        return view('packages.index', compact('packages'));
    }

    public function show(string $slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('packages.show', compact('package'));
    }
}
