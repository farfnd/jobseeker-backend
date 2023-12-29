<?php

namespace App\Support\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasMacros
{
    /**
     * Register whereLike macro to the Eloquent Builder.
     *
     * @return void
     */
    protected function registerWhereLikeMacroToBuilder(): void
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });

                            return $query;
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");

                            return $query;
                        }
                    );
                }
            });

            return $this;
        });
    }

    /**
     * Register nested whereLike macro to the Eloquent Builder.
     *
     * @return void
     */
    protected function registerNestedWhereLikeMacroToBuilder(): void
    {
        Builder::macro('whereLikeNested', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $index => $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm, $index) {
                            [$relationName[$index], $relationAttribute[$index]] = explode('.', $attribute, 2);

                            $query->orWhereHas($relationName[$index], function (Builder $query) use ($index, $relationName, $relationAttribute, $searchTerm) {
                                $query->whereLikeNested($relationAttribute[$index], $searchTerm)->when(
                                    $relationName[$index] === 'translations',
                                    function (Builder $query) {
                                        $query->where('locale', 'en');

                                        return $query;
                                    }
                                );
                            });

                            return $query;
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");

                            return $query;
                        }
                    );
                }
            });

            return $this;
        });
    }

    /**
     * Register collection pagination macro.
     *
     * @return void
     */
    protected function registerPaginateMacroToCollection(): void
    {
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
