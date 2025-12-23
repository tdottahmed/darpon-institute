<?php

if (!function_exists('format_price')) {
    /**
     * Format a price amount as BDT (Bangladeshi Taka) currency.
     *
     * @param float|int|null $amount The amount to format
     * @param bool $showSymbol Whether to show the currency symbol (৳)
     * @return string Formatted price string
     */
    function format_price($amount, $showSymbol = true)
    {
        if ($amount === null || $amount === '') {
            return $showSymbol ? '৳0.00' : '0.00';
        }

        $amount = (float) $amount;
        $formatted = number_format($amount, 2, '.', ',');

        return $showSymbol ? '৳' . $formatted : $formatted;
    }
}

if (!function_exists('format_price_compact')) {
    /**
     * Format a price amount as BDT in compact form (e.g., ৳1.5K, ৳2.3M).
     *
     * @param float|int|null $amount The amount to format
     * @return string Formatted price string
     */
    function format_price_compact($amount)
    {
        if ($amount === null || $amount === '') {
            return '৳0';
        }

        $amount = (float) $amount;

        if ($amount >= 1000000) {
            return '৳' . number_format($amount / 1000000, 1) . 'M';
        } elseif ($amount >= 1000) {
            return '৳' . number_format($amount / 1000, 1) . 'K';
        }

        return '৳' . number_format($amount, 0);
    }
}
