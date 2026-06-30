<?php

if (!function_exists('bn_num')) {
    /**
     * Convert English digits in a string to Bangla numerals when the
     * active locale is Bangla. Leaves everything else untouched.
     */
    function bn_num(string|int|float $value): string
    {
        $value = (string) $value;

        if (app()->getLocale() !== 'bn') {
            return $value;
        }

        return strtr($value, [
            '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
            '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
        ]);
    }
}

if (!function_exists('bn_taka')) {
    /**
     * Format a number as a Taka amount with thousands separators,
     * using Bangla numerals when locale is Bangla.
     */
    function bn_taka(int|float $amount): string
    {
        return '৳' . bn_num(number_format($amount));
    }
}
