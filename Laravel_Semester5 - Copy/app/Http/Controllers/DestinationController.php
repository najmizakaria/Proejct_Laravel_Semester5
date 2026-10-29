<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /** GET /destinations - list all (eager loads category to avoid N+1) */
    public function index()
    {
        $destinations = Destination::with('category')->latest('id')->get();

        return view('destinations.index', compact('destinations'));
    }

    /** GET /destinations/create - show the empty form */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('destinations.create', compact('categories'));
    }

    /** POST /destinations - validate, save, redirect */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'country' => 'required|string|min:2|max:100',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:999999',
            'rating' => 'required|numeric|between:0,5',
            'image' => 'nullable|string|max:255',
            'description' => 'required|string|min:20',
            'is_featured' => 'nullable|boolean',
        ]);

        // Unchecked checkboxes are not submitted at all, so read it as a boolean
        $validated['is_featured'] = $request->boolean('is_featured');

        $destination = Destination::create($validated);

        return redirect()
            ->route('destinations.index')
            ->with('success', "“{$destination->name}” was added successfully!");
    }

    /** GET /destinations/{destination} - route model binding (404 handled automatically) */
    public function show(Destination $destination)
    {
        $destination->load('category');

        return view('destinations.show', compact('destination'));
    }

    /** GET /destinations/{destination}/edit - pre-filled form */
    public function edit(Destination $destination)
    {
        $categories = Category::orderBy('name')->get();

        return view('destinations.edit', compact('destination', 'categories'));
    }

    /** PUT /destinations/{destination} - validate, update, redirect */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'country' => 'required|string|min:2|max:100',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:999999',
            'rating' => 'required|numeric|between:0,5',
            'image' => 'nullable|string|max:255',
            'description' => 'required|string|min:20',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        $destination->update($validated);

        return redirect()
            ->route('destinations.show', $destination)
            ->with('success', "“{$destination->name}” was updated successfully!");
    }

    /** DELETE /destinations/{destination} */
    public function destroy(Destination $destination)
    {
        $destination->delete();

        return redirect()
            ->route('destinations.index')
            ->with('success', "“{$destination->name}” was deleted.");
    }
}
