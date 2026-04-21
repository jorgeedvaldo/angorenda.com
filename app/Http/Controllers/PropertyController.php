<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    /**
     * Display a listing of active properties with filters.
     */
    public function index(Request $request): View
    {
        $query = Property::query()
            ->where('is_active', true)
            ->with(['images', 'user']);

        if ($request->filled('q')) {
            $term = $request->input('q');
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->input('purpose'));
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->input('property_type'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        $properties = $query->latest()->paginate(12)->withQueryString();

        return view('properties.index', compact('properties'));
    }

    /**
     * Display the specified property by slug.
     */
    public function show(string $slug): View
    {
        $property = Property::where('slug', $slug)
            ->where('is_active', true)
            ->with(['user', 'images'])
            ->firstOrFail();

        $relatedProperties = Property::where('is_active', true)
            ->where('id', '!=', $property->id)
            ->where(function ($query) use ($property) {
                $query->where('city', $property->city)
                      ->orWhere('property_type', $property->property_type);
            })
            ->with('images')
            ->limit(4)
            ->get();

        return view('properties.show', compact('property', 'relatedProperties'));
    }
}
