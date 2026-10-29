<?php

namespace App\Http\Controllers;

use App\Models\Destination;

// Single-action controller: the home page is not one of the 7 RESTful actions,
// so it gets its own controller instead of an "8th action" on DestinationController.
class HomeController extends Controller
{
    public function __invoke()
    {
        $destinations = Destination::with('category')
            ->where('is_featured', true)
            ->orderByDesc('rating')
            ->get();

        return view('home', compact('destinations'));
    }
}
