<?php

namespace BinaryCastle\Boilerplate\Services\Installer;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Navigator
{
    public static function activeSteps(): Collection
    {
        $requireSteps = collect(config('boilerplate.fixed_steps'));
        $enableSteps = config('boilerplate.steps_enable');
        $steps = collect(config('boilerplate.steps'))->filter(function ($item, $key) use ($enableSteps) {
            return isset($enableSteps[$key]) && $enableSteps[$key];
        });

        $sortedSteps = $steps->sortBy(function ($item, $key) use ($enableSteps) {
            return array_search($key, array_keys($enableSteps));
        });
        return $requireSteps->merge($sortedSteps);
    }

    public static function next()
    {
        $currentRoute = Str::replace(['installer/', 'installer'], '', Route::current()->uri());
        $found = false;
        return self::activeSteps()->first(function ($item) use ($currentRoute, &$found) {
            if ($found) {
                return $item;
            }

            if ($item['url'] == $currentRoute) {
                $found = true;
            }
            return false;
        });
    }

    public static function previous()
    {
        $currentRoute = Str::replace(['installer/', 'installer'], '', Route::current()->uri());
        $previousItem = null;
        $found = false;

        self::activeSteps()->each(function ($item) use ($currentRoute, &$previousItem, &$found) {
            if ($item["url"] === $currentRoute) {
                $found = true;
            } elseif (!$found) {
                // Set the previous item if the search URL hasn't been found yet
                $previousItem = $item;
            }
        });

        return $previousItem;
    }

    public static function canSkipCurrent(): bool
    {
        $currentRoute = Str::replace(['installer/', 'installer'], '', Route::current()->uri());
        $skippable = false;
        self::activeSteps()->each(function ($item) use ($currentRoute, &$skippable) {
            if ($item["url"] === $currentRoute && Arr::has($item, 'skippable')) {
                if (Arr::get($item, 'skippable', false) === true) {
                    $skippable = true;
                }
            }
        });
        return $skippable;
    }
}
