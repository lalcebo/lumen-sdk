<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 7/26/21 9:47 AM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Support;

use Illuminate\Support\Str as IlluminateStr;

/**
 * @package Lalcebo\Lumen\Support
 */
class Str extends IlluminateStr
{
    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public static function contains($haystack, $needles): bool
    {
        return \Lalcebo\Helpers\Str::contains($needles, $haystack);
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public static function containsAll($haystack, array $needles): bool
    {
        return \Lalcebo\Helpers\Str::containsAll($needles, $haystack);
    }

    /**
     * Determine if a given string contains a given substring case-insensitive.
     *
     * @param string $haystack The input string
     * @param string|array $needles
     * @return bool True if $haystack contain any case-insensitive substring on $needles.
     *
     * @codeCoverageIgnore
     */
    public static function containsInsensitive(string $haystack, $needles): bool
    {
        return \Lalcebo\Helpers\Str::containsInsensitive($needles, $haystack);
    }

    /**
     * Determine if a given string contains all array values case-insensitive.
     *
     * @param string $haystack
     * @param string[] $needles
     * @return bool True if $haystack contain all case-insensitive substring on $needles.
     *
     * @codeCoverageIgnore
     */
    public static function containsAllInsensitive(string $haystack, array $needles): bool
    {
        return \Lalcebo\Helpers\Str::containsAllInsensitive($needles, $haystack);
    }
}
