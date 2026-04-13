<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = CustomPage::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return Inertia::render('Frontend/CustomPage', [
            'page' => $page
        ]);
    }
}
