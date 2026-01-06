<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     */
    public function show($slug)
    {
        $landingPage = LandingPage::where('slug', $slug)
            ->where('status', true)
            ->with('book')
            ->firstOrFail();

        // Ensure book exists for book-type landing pages
        if ($landingPage->product_type === 'book' && !$landingPage->book) {
            abort(404, 'Book not found for this landing page');
        }

        return view('frontend.landing_page', compact('landingPage'));
    }
}
