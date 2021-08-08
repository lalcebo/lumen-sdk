<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 7/25/21 4:56 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Providers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;
use Lalcebo\Lumen\Http\FormRequest;

/**
 * @package Lalcebo\Lumen\Providers
 *
 * @see https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/Providers/FormRequestServiceProvider.php
 * @author https://github.com/laravel/framework/graphs/contributors
 */
class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(FormRequest::class, function ($request, $app) {
            (FormRequest::createFrom($app['request'], $request))->setContainer($app);
        });
    }
}
