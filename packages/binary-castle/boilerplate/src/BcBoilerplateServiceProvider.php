<?php

namespace BinaryCastle\Boilerplate;

use Illuminate\Contracts\Http\Kernel;
use BinaryCastle\Boilerplate\Http\Middleware\VerifyInstall;
use BinaryCastle\Boilerplate\Providers\SearchableServiceProvider;
use BinaryCastle\Boilerplate\Providers\SortableServiceProvider;
use BinaryCastle\Boilerplate\View\Components\InstallerNavigationButtons;
use BinaryCastle\Boilerplate\View\Components\InstallerTimeline;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class BcBoilerplateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/boilerplate.php', 'boilerplate');

        $this->app->register(SearchableServiceProvider::class);
        $this->app->register(SortableServiceProvider::class);
    }

    public function boot(Router $router): void
    {
        $this->publishes([
            __DIR__ . '/../config/boilerplate.php' => config_path('boilerplate.php'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'boilerplate');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/boilerplate'),
        ], 'public');

        Route::prefix('installer')->as('installer.')->middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            $this->loadRoutesFrom(__DIR__ . '/../routes/install.php');
        });

        Route::prefix('api')->as('bc-api.')->middleware('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });


        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        Validator::extend('valid_email', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value);
        });

        Validator::replacer('valid_email', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be a valid email address.');
        });

        Blade::component('installer-timeline', InstallerTimeline::class);
        Blade::component('installer-navigation-buttons', InstallerNavigationButtons::class);
    }
}
