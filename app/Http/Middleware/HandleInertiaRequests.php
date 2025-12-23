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
        ];
    }
}
