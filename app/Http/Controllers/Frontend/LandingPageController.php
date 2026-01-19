<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\PaymentGateway;
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
            ->with(['book', 'course'])
            ->firstOrFail();

        $paymentGateways = [];
        // Ensure product exists and get additional data
        if ($landingPage->product_type === 'course') {
            if (!$landingPage->course) {
                abort(404, 'Course not found for this landing page');
            }
            $paymentGateways = PaymentGateway::active()->get();
        } elseif ($landingPage->product_type === 'book') {
            if (!$landingPage->book) {
                abort(404, 'Book not found for this landing page');
            }
        }

        return view('frontend.landing_page', compact('landingPage', 'paymentGateways'));
    }
}
