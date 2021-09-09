<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/2/21 1:22 PM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

/**
 * @method static Builder filters(array $filters)
 * @method static Builder filtersWhen(bool $condition, array $filters, array $default)
 */
trait Filterable
{
    /**
     * Apply a filters to query.
     *
     * @param Builder $query
     * @param array   $filters
     *
     * @return Builder
     */
    public function scopeFilters(Builder $query, array $filters): Builder
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();
    }

    /**
     * Apply filters to query if the given "condition" is truthy.
     *
     * @param Builder    $query
     * @param bool       $condition
     * @param array      $filters
     * @param array|null $default
     *
     * @return Builder
     */
    public function scopeFiltersWhen(Builder $query, bool $condition, array $filters, array $default = null): Builder
    {
        if ($condition) {
            return $this->scopeFilters($query, $filters);
        }

        if ($default) {
            return $this->scopeFilters($query, $default);
        }

        return $query;
    }
}
