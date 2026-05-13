<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class GoogleTagManagerComposer
{
    /**
     * Attach Google Tag Manager snippets to frontend root layouts.
     */
    public function compose(View $view): void
    {
        try {
            $view->with([
                'gtmHead' => Setting::get('gtm_head'),
                'gtmBody' => Setting::get('gtm_body'),
            ]);
        } catch (\Throwable) {
            $view->with([
                'gtmHead' => null,
                'gtmBody' => null,
            ]);
        }
    }
}
