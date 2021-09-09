<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 8/8/21 9:56 AM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Exceptions\Concerns;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Response render(Request $request)
 */
trait Httpable
{
    /**
     * Report only when running in a queued job or scheduled task.
     *
     * @return bool
     */
    public function report(): bool
    {
        /**
         * @note It is confusing to return !app()->runningInConsole()
         *
         * @see https://github.com/laravel/lumen-framework/blob/master/src/Exceptions/Handler.php#L47
         */
        return !app()->runningInConsole();
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode ?? Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers ?? [];
    }
}
