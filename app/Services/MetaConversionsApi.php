<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Server-side Meta Conversions API.
 *
 * Events are sent after the response is flushed, so a slow or failing Graph API
 * call never delays or breaks checkout. Each event reuses the browser pixel's
 * eventID so Meta deduplicates the pair into a single conversion.
 */
class MetaConversionsApi
{
    private const GRAPH_VERSION = 'v23.0';

    /**
     * @param string $eventName  Standard event name (Purchase, Lead, ...)
     * @param string $eventId    Same ID the browser pixel uses for this event
     * @param array  $customer   Raw customer data: email, phone, name, external_id
     * @param array  $customData Event parameters: value, currency, content_name, ...
     */
    public static function track(string $eventName, string $eventId, array $customer = [], array $customData = [], ?Request $request = null): void
    {
        $pixelId = Setting::get('meta_pixel_id');
        $token = Setting::get('meta_capi_access_token');
        $enabled = (string) Setting::get('meta_pixel_enabled', '0') === '1';

        if (! $enabled || ! $pixelId || ! $token) {
            return;
        }

        $request ??= request();

        $event = [
            'event_name' => $eventName,
            'event_time' => time(),
            'event_id' => $eventId,
            'action_source' => 'website',
            // POSTs come from the form page, which is the URL Meta should attribute to
            'event_source_url' => $request->isMethod('GET') ? $request->fullUrl() : ($request->headers->get('referer') ?: $request->fullUrl()),
            'user_data' => self::userData($customer, $request),
            'custom_data' => array_filter($customData, fn ($v) => $v !== null && $v !== []),
        ];

        $payload = ['data' => [$event]];
        if ($testCode = Setting::get('meta_capi_test_event_code')) {
            $payload['test_event_code'] = $testCode;
        }

        $url = sprintf('https://graph.facebook.com/%s/%s/events', self::GRAPH_VERSION, $pixelId);

        dispatch(function () use ($url, $payload, $token, $eventName, $eventId) {
            try {
                $response = Http::timeout(5)->asJson()->post($url . '?access_token=' . urlencode($token), $payload);
                if ($response->failed()) {
                    logger()->warning("Meta CAPI {$eventName} ({$eventId}) failed: " . $response->body());
                }
            } catch (\Throwable $e) {
                logger()->warning("Meta CAPI {$eventName} ({$eventId}) error: " . $e->getMessage());
            }
        })->afterResponse();
    }

    private static function userData(array $customer, Request $request): array
    {
        $nameParts = preg_split('/\s+/', trim((string) ($customer['name'] ?? '')), 2);

        $data = [
            'em' => self::hash($customer['email'] ?? null),
            'ph' => self::hash(self::normalizePhone($customer['phone'] ?? null)),
            'fn' => self::hash($nameParts[0] ?? null),
            'ln' => self::hash($nameParts[1] ?? null),
            'country' => self::hash('bd'),
            'external_id' => self::hash(isset($customer['external_id']) ? (string) $customer['external_id'] : null),
            'client_ip_address' => $request->ip(),
            'client_user_agent' => $request->userAgent(),
            'fbp' => $request->cookie('_fbp'),
            'fbc' => $request->cookie('_fbc') ?: self::fbcFromReferer($request),
        ];

        return array_filter($data, fn ($v) => $v !== null && $v !== '');
    }

    private static function hash(?string $value): ?string
    {
        $value = mb_strtolower(trim((string) $value));

        return $value === '' ? null : hash('sha256', $value);
    }

    /** Meta expects digits with country code, e.g. 01712345678 -> 8801712345678. */
    private static function normalizePhone(?string $phone): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $phone);

        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0') && strlen($digits) === 11) {
            return '88' . $digits;
        }
        if (strlen($digits) === 10 && str_starts_with($digits, '1')) {
            return '880' . $digits;
        }

        return $digits;
    }

    /** Builds an fbc value from an fbclid on the referring page when the _fbc cookie is missing. */
    private static function fbcFromReferer(Request $request): ?string
    {
        $query = parse_url((string) $request->headers->get('referer'), PHP_URL_QUERY);
        parse_str((string) $query, $params);

        return ! empty($params['fbclid']) ? 'fb.1.' . (int) (microtime(true) * 1000) . '.' . $params['fbclid'] : null;
    }
}
