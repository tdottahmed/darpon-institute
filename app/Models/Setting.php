<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'gtm_head',
        'gtm_body',
    ];

    /** @var list<string> */
    protected static array $columnBackedKeys = ['gtm_head', 'gtm_body'];

    protected static function isColumnBackedKey(string $key): bool
    {
        return in_array($key, self::$columnBackedKeys, true);
    }

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (! $setting) {
            return $default;
        }

        if (self::isColumnBackedKey($key)) {
            $columnValue = $setting->{$key};
            if ($columnValue !== null && $columnValue !== '') {
                return $columnValue;
            }

            return $setting->value !== null && $setting->value !== '' ? $setting->value : $default;
        }

        return $setting->value;
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value)
    {
        if (self::isColumnBackedKey($key)) {
            $normalized = ($value === '' || $value === null) ? null : $value;

            return self::updateOrCreate(
                ['key' => $key],
                [
                    $key => $normalized,
                    'value' => null,
                ]
            );
        }

        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
