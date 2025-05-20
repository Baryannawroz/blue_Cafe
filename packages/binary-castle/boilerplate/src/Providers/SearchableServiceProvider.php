<?php

namespace Binarycastle\Boilerplate\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class SearchableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $search = request('search');
        Builder::macro('whereLike', function ($modelClass) use ($search) {
            $model = new $modelClass;
            return $this->when(!empty($search), function ($query) use ($model, $search) {
                return $query->where(function (Builder $query) use ($model, $search) {
                    $searchableColumns = $model::getSearchableColumns();
                    foreach ($searchableColumns as $column) {
                        if (!str_contains($column, '.')) {
                            $column = $model->getTable() . '.' . $column;
                        }
                        $query->orWhere($column, 'LIKE', "%{$search}%");
                    }
                });
            });
        });
    }
}
