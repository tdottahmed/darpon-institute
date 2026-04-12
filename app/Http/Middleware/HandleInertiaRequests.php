<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'translations' => function () {
                return file_exists(lang_path('en/common.php'))
                    ? ['common' => require lang_path('en/common.php')]
                    : ['common' => []];
            },
            'frontend_content' => function () {
                $locale = app()->getLocale();
                return \Illuminate\Support\Facades\Cache::remember("frontend_content_{$locale}", 60 * 24 * 30, function () use ($locale) {
                    return \App\Models\FrontendContent::all()
                        ->groupBy('section')
                        ->map(fn($items) => $items->pluck('value', 'key')->map(function ($value) use ($locale) {
                            if (is_array($value)) {
                                return $value[$locale] ?? $value['en'] ?? $value;
                            }
                            return $value;
                        }));
                });
            },
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
                'warning' => $request->session()->get('warning'),
                'info' => $request->session()->get('info'),
            ],
            'locale' => app()->getLocale(),
            'settings' => function () {
                try {
                    if (class_exists(\App\Models\Setting::class)) {
                        return [
                            'social_facebook' => \App\Models\Setting::get('social_facebook'),
                            'social_instagram' => \App\Models\Setting::get('social_instagram'),
                            'social_twitter' => \App\Models\Setting::get('social_twitter'),
                            'social_youtube' => \App\Models\Setting::get('social_youtube'),
                            'company_address' => \App\Models\Setting::get('company_address'),
                            'company_phone' => \App\Models\Setting::get('company_phone'),
                            'company_email' => \App\Models\Setting::get('company_email'),
                            'rss_feed_url' => \App\Models\Setting::get('rss_feed_url'),
                            'logo_light' => \App\Models\Setting::get('logo_light')
                                ? \Illuminate\Support\Facades\Storage::url(\App\Models\Setting::get('logo_light'))
                                : '/darponbdv.png',
                            'logo_dark' => \App\Models\Setting::get('logo_dark')
                                ? \Illuminate\Support\Facades\Storage::url(\App\Models\Setting::get('logo_dark'))
                                : null,
                            'header_footer_color_light' => \App\Models\Setting::get('header_footer_color_light', '#ffffff'),
                            'header_footer_color_dark' => \App\Models\Setting::get('header_footer_color_dark', '#111827'),
                        ];
                    }
                } catch (\Exception $e) {
                    // Silently fail if database is not available
                }
                return [
                    'social_facebook' => null,
                    'social_instagram' => null,
                    'social_twitter' => null,
                    'social_youtube' => null,
                    'company_address' => null,
                    'company_phone' => null,
                    'company_email' => null,
                    'rss_feed_url' => null,
                    'logo_light' => '/darponbdv.png',
                    'logo_dark' => null,
                    'header_footer_color_light' => '#ffffff',
                    'header_footer_color_dark' => '#111827',
                ];
            },
            'custom_pages' => function () {
                try {
                    if (class_exists(\App\Models\CustomPage::class)) {
                        return \Illuminate\Support\Facades\Cache::remember('active_custom_pages', 60 * 24, function () {
                            return \App\Models\CustomPage::where('is_active', true)->select('id', 'title', 'slug')->get();
                        });
                    }
                } catch (\Exception $e) {
                    // Silently fail
                }
                return [];
            },
        ];
    }
}
