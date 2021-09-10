<?php

/** @noinspection StaticClosureCanBeUsedInspection */

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:34 PM.
 */

declare(strict_types=1);

use Lalcebo\Lumen\Exceptions\Concerns\Httpable;

function makeMockTrait(): object
{
    return Mockery::mock(Httpable::class)
        ->makePartial();
}

it('status code is numeric')
    ->expect(makeMockTrait()->getStatusCode())
    ->toBeInt();

it('headers is array')
    ->expect(makeMockTrait()->getHeaders())
    ->toBeArray();
