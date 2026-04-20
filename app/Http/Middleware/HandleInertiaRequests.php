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
     * Pick a non-empty translation from { en, bn, ... }.
     * PHP's ?? cannot fall back when the key exists but is '' (common for images uploaded only on EN).
     *
     * @param  array<string, mixed>  $value
     */
    protected static function pickLocalizedArrayValue(array $value, string $locale): mixed
    {
        foreach (array_unique([$locale, 'en', 'bn']) as $lang) {
            if (! array_key_exists($lang, $value)) {
                continue;
            }
            $cell = $value[$lang];
            if ($cell !== null && $cell !== '') {
                return $cell;
            }
        }

        return $value[$locale] ?? $value['en'] ?? '';
    }

    /** URLs / files: fall back across locales. Text fields keep strict ?? behaviour. */
    protected static function isImageLikeFrontendKey(string $key): bool
    {
        return str_starts_with($key, 'slider_image')
            || in_array($key, ['hero_image', 'bg_image'], true);
    }

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
        $props = [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'translations' => function () {
                return \Illuminate\Support\Facades\Cache::remember('translations_common', 60 * 24, function () {
                    return file_exists(lang_path('en/common.php'))
                        ? ['common' => require lang_path('en/common.php')]
                        : ['common' => []];
                });
            },
            'frontend_content' => function () {
                $locale = app()->getLocale();
                return \Illuminate\Support\Facades\Cache::remember("frontend_content_{$locale}", 60 * 24 * 30, function () use ($locale) {
                    return \App\Models\FrontendContent::all()
                        ->groupBy('section')
                        ->map(fn ($items) => $items->pluck('value', 'key')->map(function ($value, $key) use ($locale) {
                            if (is_array($value)) {
                                if (self::isImageLikeFrontendKey((string) $key)) {
                                    return self::pickLocalizedArrayValue($value, $locale);
                                }

                                return $value[$locale] ?? $value['en'] ?? $value;
                            }

                            return $value;
                        }))
                        ->toArray();
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
                    return \Illuminate\Support\Facades\Cache::remember('site_settings', 60 * 24, function () {
                        $s = \App\Models\Setting::class;
                        $storage = \Illuminate\Support\Facades\Storage::class;
                        $logoLight = $s::get('logo_light');
                        $logoDark = $s::get('logo_dark');
                        return [
                            'social_facebook' => $s::get('social_facebook'),
                            'social_instagram' => $s::get('social_instagram'),
                            'social_twitter' => $s::get('social_twitter'),
                            'social_youtube' => $s::get('social_youtube'),
                            'company_address' => $s::get('company_address'),
                            'company_phone' => $s::get('company_phone'),
                            'company_email' => $s::get('company_email'),
                            'whatsapp_number' => $s::get('whatsapp_number'),
                            'rss_feed_url' => $s::get('rss_feed_url'),
                            'logo_light' => $logoLight ? $storage::url($logoLight) : '/darponbdv.png',
                            'logo_dark' => $logoDark ? $storage::url($logoDark) : null,
                            'header_footer_color_light' => $s::get('header_footer_color_light', '#ffffff'),
                            'header_footer_color_dark' => $s::get('header_footer_color_dark', '#111827'),
                            'map_embed_url' => $s::get('map_embed_url'),
                        ];
                    });
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
                    'whatsapp_number' => null,
                    'rss_feed_url' => null,
                    'logo_light' => '/darponbdv.png',
                    'logo_dark' => null,
                    'header_footer_color_light' => '#ffffff',
                    'header_footer_color_dark' => '#111827',
                    'map_embed_url' => null,
                ];
            },
            'custom_pages' => function () {
                try {
                    return \Illuminate\Support\Facades\Cache::remember('active_custom_pages', 60 * 24, function () {
                        return \App\Models\CustomPage::where('is_active', true)->select('id', 'title', 'slug')->get();
                    });
                } catch (\Exception $e) {
                    // Silently fail
                }
                return [];
            },
        ];
        return $props;
    }
}
