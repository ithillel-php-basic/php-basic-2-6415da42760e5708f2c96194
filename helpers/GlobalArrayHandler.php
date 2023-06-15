<?php

namespace helpers;

class GlobalArrayHandler
{
    /**
     * Конвертує строкове значення в числове.
     * Також фільтрує від наукових записів, шістнадцяткових, бінарних та октальних чисел.
     *
     * @param string $key
     * @return int|null
     */
    public static function getStringToInt(string $key): int|null
    {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            if (self::isScientificNotation($_GET[$key])
                || self::isHexadecimal($_GET[$key])
                || self::isBinary($_GET[$key])
                || self::isOctal($_GET[$key])) {
                return null;
            }

            $value = intval($_GET[$key]);

            if ($value <= 0) {
                return null;
            }

            return $value;
        }

        return null;
    }


    /**
     * Повертає query string зі знаком питання.
     *
     * @return string
     */
    public static function getQueryString(): string
    {
        $queryStr = '';
        if (!empty($_SERVER['QUERY_STRING'])) {
            return '?'.$_SERVER['QUERY_STRING'];
        }

        return $queryStr;
    }

    private static function isScientificNotation(string $value): bool
    {
        return is_numeric($value) && str_contains(strtolower($value), 'e') !== false;
    }

    private static function isHexadecimal(string $value): bool
    {
        return preg_match('/^0x[0-9A-Fa-f]+$/', $value);
    }

    private static function isBinary(string $value): bool
    {
        return preg_match('/^0b[01]+$/', $value);
    }

    private static function isOctal(string $value): bool
    {
        return preg_match('/^0[0-7]+$/', $value);
    }
}