<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 7/26/21 1:23 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Support;

use Illuminate\Support\Arr as IlluminateArr;
use Illuminate\Support\Collection;

class Arr extends IlluminateArr
{
    /**
     * Convert single level array to multidimensional array.
     *
     * @param array $array
     * @param string $delimiter
     * @return array
     *
     * @codeCoverageIgnore
     */
    public static function dimensional(array $array, string $delimiter = '_'): array
    {
        return \Lalcebo\Helpers\Arr::dimensional($array, $delimiter);
    }

    /**
     * Filters recursive elements of an array using the given callback.
     *
     * @param array $array
     * @param callable $callback
     * @param int $flag
     * @return array
     *
     * @codeCoverageIgnore
     */
    public static function whereRecursive(array $array, callable $callback, int $flag = 0): array
    {
        return \Lalcebo\Helpers\Arr::filterRecursive($array, $callback, $flag);
    }

    /**
     * Convert a single or multidimensional array to collection.
     *
     * @param array $array
     * @return Collection
     */
    public static function toCollection(array $array): Collection
    {
        return new Collection(
            array_map(
                static function ($item) {
                    return is_array($item) || is_object($item) ? new Collection($item) : $item;
                },
                $array
            )
        );
    }
}
