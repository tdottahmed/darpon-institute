<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class FrontendController extends Controller
{
    /**
     * Show the frontend dashboard.
     */
    public function dashboard(): Response|RedirectResponse
    {
        // Redirect admin users to admin dashboard
        // if (Auth::user()->user_type === 'admin') {
        //     return redirect()->route('admin.dashboard');
        // }

        return Inertia::render('Dashboard');
    }
}
