<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 7/25/21 4:53 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Http;

use Closure;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;
use Lalcebo\Lumen\Http\FormRequest;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class FormRequestTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    /**
     * @throws BindingResolutionException
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function testValidatedMethodReturnsTheValidatedData(): void
    {
        $request = $this->createRequest(['name' => 'specified', 'with' => 'extras']);
        $request->validateResolved();
        $this->assertEquals(['name' => 'specified'], $request->validated());
    }

    /**
     * @throws BindingResolutionException
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function testValidatedMethodReturnsTheValidatedDataNestedRules(): void
    {
        $payload = ['nested' => ['foo' => 'bar', 'baz' => ''], 'array' => [1, 2]];
        $request = $this->createRequest($payload, FormRequestNestedStub::class);
        $request->validateResolved();
        $this->assertEquals(['nested' => ['foo' => 'bar'], 'array' => [1, 2]], $request->validated());
    }

    /**
     * @throws AuthorizationException
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function testValidatedMethodReturnsTheValidatedDataNestedChildRules(): void
    {
        $payload = ['nested' => ['foo' => 'bar', 'with' => 'extras']];
        $request = $this->createRequest($payload, FormRequestNestedChildStub::class);
        $request->validateResolved();
        $this->assertEquals(['nested' => ['foo' => 'bar']], $request->validated());
    }

    /**
     * @throws AuthorizationException
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function testValidatedMethodReturnsTheValidatedDataNestedArrayRules(): void
    {
        $payload = ['nested' => [['bar' => 'baz', 'with' => 'extras'], ['bar' => 'baz2', 'with' => 'extras']]];
        $request = $this->createRequest($payload, FormRequestNestedArrayStub::class);
        $request->validateResolved();
        $this->assertEquals(['nested' => [['bar' => 'baz'], ['bar' => 'baz2']]], $request->validated());
    }

    /**
     * @throws BindingResolutionException
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function testValidatedMethodNotValidateTwice(): void
    {
        $payload = ['name' => 'specified', 'with' => 'extras'];
        $request = $this->createRequest($payload, FormRequestTwiceStub::class);
        $request->validateResolved();
        $request->validated();
        $this->assertEquals(1, FormRequestTwiceStub::$count);
    }

    /**
     * @throws AuthorizationException
     * @throws BindingResolutionException
     */
    public function testValidateThrowsWhenValidationFails(): void
    {
        $this->expectException(ValidationException::class);
        $request = $this->createRequest(['no' => 'name']);
        $request->validateResolved();
    }

    public function testValidateMethodThrowsWhenAuthorizationFails(): void
    {
        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('This action is unauthorized.');
        $this->createRequest([], FormRequestForbiddenStub::class)->validateResolved();
    }

    /**
     * @throws AuthorizationException
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function test_after_validation_runs_after_validation(): void
    {
        $request = $this->createRequest([], FormRequestHooks::class);
        $request->validateResolved();
        $this->assertEquals(['name' => 'Adam'], $request->all());
    }

    /**
     * Catch the given exception thrown from the executor, and return it.
     *
     * @param string $class
     * @param Closure $executor
     * @return Exception
     *
     * @throws Exception
     */
    protected function catchException(string $class, Closure $executor): Exception
    {
        try {
            $executor();
        } catch (Exception $e) {
            if (is_a($e, $class)) {
                return $e;
            }
            throw $e;
        }
        throw new Exception("No exception thrown. Expected exception {$class}.");
    }

    /**
     * Create a new request of the given type.
     *
     * @param array $payload
     * @param string $class
     * @return FormRequest
     */
    protected function createRequest(array $payload = [], string $class = FormRequestStub::class): FormRequest
    {
        $container = tap(new Container(), function ($container) {
            $container->instance(
                ValidationFactoryContract::class,
                $this->createValidationFactory($container)
            );
        });
        /** @noinspection PhpUndefinedMethodInspection */
        $request = $class::create('/', 'GET', $payload);
        return $request->setContainer($container);
    }

    /**
     * Create a new validation factory.
     *
     * @param Container $container
     * @return ValidationFactory
     */
    protected function createValidationFactory(Container $container): ValidationFactory
    {
        $translator = m::mock(Translator::class)
            ->shouldReceive('get')
            ->zeroOrMoreTimes()
            ->andReturn('error')
            ->getMock();
        /** @noinspection PhpParamsInspection */
        return new ValidationFactory($translator, $container);
    }
}

class FormRequestStub extends FormRequest
{
    public function rules(): array
    {
        return ['name' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }
}

class FormRequestNestedStub extends FormRequest
{
    public function rules(): array
    {
        return ['nested.foo' => 'required', 'array.*' => 'integer'];
    }

    public function authorize(): bool
    {
        return true;
    }
}

class FormRequestNestedChildStub extends FormRequest
{
    public function rules(): array
    {
        return ['nested.foo' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }
}

class FormRequestNestedArrayStub extends FormRequest
{
    public function rules(): array
    {
        return ['nested.*.bar' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }
}

class FormRequestTwiceStub extends FormRequest
{
    public static $count = 0;

    public function rules(): array
    {
        return ['name' => 'required'];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function () {
            self::$count++;
        });
    }

    public function authorize(): bool
    {
        return true;
    }
}

class FormRequestForbiddenStub extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
}

class FormRequestHooks extends FormRequest
{
    public function rules(): array
    {
        return ['name' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->replace(['name' => 'Taylor']);
    }

    public function passedValidation(): void
    {
        $this->replace(['name' => 'Adam']);
    }
}
