<?php

namespace Binarycastle\Boilerplate\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class SortableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $sort = request('sort', 'id');
        $sortDirection = 'asc'; // Default to ascending
        if (str_starts_with($sort, '-')) {
            $sortDirection = 'desc';
            $sort = substr($sort, 1); // Remove the hyphen
        }

        Builder::macro('orderBySortable', function ($modelClass) use ($sort, $sortDirection) {
            $model = new $modelClass;
            if (!in_array($sort, $model::getSortableColumns())) {
                return $this->orderByDesc($model->getTable() . '.id');
            }

            if (!str_contains($sort, '.')) {
                $sort = $model->getTable() . '.' . $sort;
            }
            return $this->orderBy($sort, $sortDirection);
        });
    }
}

