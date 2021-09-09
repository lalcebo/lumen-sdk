<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 7/25/21 4:53 PM.
 */

declare(strict_types=1);

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryContract;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;
use Lalcebo\Lumen\Http\FormRequest;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestForbiddenStub;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestHooks;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestNestedArrayStub;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestNestedChildStub;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestNestedStub;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestStub;
use Lalcebo\Lumen\Tests\Mocks\Http\Requests\FormRequestTwiceStub;

/**
 * Create a new request of the given type.
 *
 * @param array $payload
 * @param string $class
 *
 * @return FormRequest
 * @noinspection PhpParamsInspection
 * @noinspection PhpUndefinedMethodInspection
 */
function makeRequest(array $payload = [], string $class = FormRequestStub::class): FormRequest
{
    return $class::create('/', 'GET', $payload)
        ->setContainer(
            tap(new Container(), function ($container) {
                return $container->instance(
                    ValidationFactoryContract::class,
                    new ValidationFactory(
                        Mockery::mock(Translator::class)
                            ->shouldReceive('get')
                            ->zeroOrMoreTimes()
                            ->andReturn('error')
                            ->getMock(),
                        $container
                    )
                );
            })
        );
}

afterEach(function () {
    Mockery::close();
});

it('returns the validated data', function () {
    $form = makeRequest(['name' => 'specified', 'with' => 'extras']);
    $form->validateResolved();
    expect($form->validated())->toEqual(['name' => 'specified']);
});

it('returns the validated data using nested rules', function () {
    $form = makeRequest(
        ['nested' => ['foo' => 'bar', 'baz' => ''], 'array' => [1, 2]],
        FormRequestNestedStub::class
    );
    $form->validateResolved();
    expect($form->validated())->toEqual(['nested' => ['foo' => 'bar'], 'array' => [1, 2]]);
});

it('returns the validated data using nested child rules', function () {
    $form = makeRequest(
        ['nested' => ['foo' => 'bar', 'with' => 'extras']],
        FormRequestNestedChildStub::class
    );
    $form->validateResolved();
    expect($form->validated())->toEqual(['nested' => ['foo' => 'bar']]);
});

it('returns the validated data using nested array rules', function () {
    $form = makeRequest(
        ['nested' => [['bar' => 'baz', 'with' => 'extras'], ['bar' => 'baz2', 'with' => 'extras']]],
        FormRequestNestedArrayStub::class
    );
    $form->validateResolved();
    expect($form->validated())->toEqual(['nested' => [['bar' => 'baz'], ['bar' => 'baz2']]]);
});

it('not validate twice', function () {
    $form = makeRequest(['name' => 'specified', 'with' => 'extras'], FormRequestTwiceStub::class);
    $form->validateResolved();
    $form->validated();
    expect(FormRequestTwiceStub::$count)->toBeInt()->toEqual(1);
});

it('throws validation fails exception', function () {
    $form = makeRequest(['no' => 'name']);
    $form->validateResolved();
})->throws(ValidationException::class);

it('throws authorization exception', function () {
    $form = makeRequest([], FormRequestForbiddenStub::class);
    $form->validateResolved();
})->throws(AuthorizationException::class);

it('runs after validation', function () {
    $form = makeRequest([], FormRequestHooks::class);
    $form->validateResolved();
    expect($form->all())->toEqual(['name' => 'Adam']);
});
