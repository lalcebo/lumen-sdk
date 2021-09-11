<?php

/** @noinspection StaticClosureCanBeUsedInspection */

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:34 PM.
 */

declare(strict_types=1);

use Lalcebo\Lumen\Exceptions\Concerns\Httpable;

/**
 * Create mockery object for Httpable trait.
 *
 * @return object
 */
function createMockForTrait(): object
{
    return Mockery::mock(Httpable::class)->makePartial();
}

it('report is boolean', function () {
    expect(createMockForTrait()->report())->toBeBool();
});

it('status code is numeric', function () {
    expect(createMockForTrait()->getStatusCode())->toBeInt();
});

it('headers is array', function () {
    expect(createMockForTrait()->getHeaders())->toBeArray();
});
