<?php

namespace App\Support;

class FocusKeyphraseNormalizer
{
    /**
     * Turn raw request input (comma or newline separated) into a unique list of non-empty strings.
     *
     * @return list<string>
     */
    public static function toArray(mixed $input): array
    {
        if (!is_string($input)) {
            return [];
        }

        $normalized = str_replace(["\r\n", "\n", "\r"], ',', $input);
        $parts = array_map('trim', explode(',', $normalized));

        return array_values(array_unique(array_filter($parts, fn (string $p) => $p !== '')));
    }
}
