<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with recent properties.
     */
    public function index(): View
    {
        $featuredProperties = Property::where('is_active', true)
            ->with(['images', 'user'])
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProperties'));
    }
}
