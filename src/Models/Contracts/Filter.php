<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 1/16/22 8:55 PM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Models\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * @param Builder $query
     * @param Closure $next
     * @return Builder
     */
    public function handle(Builder $query, Closure $next): Builder;
}
