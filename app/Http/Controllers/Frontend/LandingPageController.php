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
            ->with(['course', 'book'])
            ->firstOrFail();

        return view('frontend.landing_page', compact('landingPage'));
    }
}
