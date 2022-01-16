<?php

/** @noinspection StaticClosureCanBeUsedInspection */

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 1/16/22 2:34 PM.
 */

declare(strict_types=1);

use Illuminate\Support\Collection;
use Lalcebo\Lumen\Support\Arr;

it('should return collection from single array', function () {
    $collection = Arr::toCollection(['foo' => 'bar']);

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->toBeIterable();

    expect($collection->get('foo'))
        ->toBe('bar');

    expect($collection->get('noExists'))
        ->toBeNull();
});

it('should return collection from multi-dimensional array', function () {
    $collection = Arr::toCollection(['foo' => ['bar' => 'baz']]);

    expect($collection->get('foo'))
        ->toBeInstanceOf(Collection::class)
        ->toBeIterable();

    expect($collection->get('foo')->get('bar'))
        ->toBe('baz');

    expect($collection->get('foo')->get('noExists'))
        ->toBeNull();
});

it('should return collection from array with object', function () {
    $collection = Arr::toCollection(['foo' => (object)['bar' => 'baz']]);

    expect($collection->get('foo'))
        ->toBeInstanceOf(Collection::class)
        ->toBeIterable();

    expect($collection->get('foo')->get('bar'))
        ->toBe('baz');

    expect($collection->get('foo')->get('noExists'))
        ->toBeNull();
});
