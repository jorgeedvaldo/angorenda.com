<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OwnerPropertyController extends Controller
{
    public function index()
    {
        $properties = auth()->user()->properties()->latest()->paginate(10);
        return view('owner.dashboard', compact('properties'));
    }

    public function create()
    {
        return view('owner.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:AOA,USD,EUR',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'purpose' => 'required|in:sale,rent',
            'property_type' => 'required|in:apartamento,casa,vivenda,terreno,armazem,escritorio,loja,edificio,fazenda,outro',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $property = auth()->user()->properties()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'area' => $validated['area'] ?? 0,
            'purpose' => $validated['purpose'],
            'property_type' => $validated['property_type'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'is_active' => true,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                // Generate path like filament does: property-images/filename.jpg
                $path = $imageFile->store('property-images', 'public');
                
                // This will trigger the PropertyImageObserver to generate the thumbnail
                $property->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('owner.dashboard')->with('success', 'Imóvel criado com sucesso!');
    }

    public function edit(Property $property)
    {
        // Auth check happens in route middleware or policy, but ensure owner:
        if ($property->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('owner.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        if ($property->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:AOA,USD,EUR',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'purpose' => 'required|in:sale,rent',
            'property_type' => 'required|in:apartamento,casa,vivenda,terreno,armazem,escritorio,loja,edificio,fazenda,outro',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'images.*' => 'nullable|image|max:5120',
        ]);

        // Manually update slug if title changed (handled in model boot mostly, but forces it indirectly)
        $property->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('property-images', 'public');
                $property->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('owner.dashboard')->with('success', 'Imóvel atualizado com sucesso!');
    }

    public function destroy(Property $property)
    {
        if ($property->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $property->delete();

        return redirect()->route('owner.dashboard')->with('success', 'Imóvel removido com sucesso!');
    }

    public function destroyImage(PropertyImage $image)
    {
        $property = $image->property;
        if ($property->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $image->delete(); // Observer cleans files

        return back()->with('success', 'Imagem removida com sucesso!');
    }
}
