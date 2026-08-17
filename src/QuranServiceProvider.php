<?php

namespace Adyatama\Quran;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Adyatama\Quran\Console\InstallCommand;
use Adyatama\Quran\Contracts\QuranServiceInterface;

class QuranServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/quran.php', 'quran');

        $this->app->singleton(Services\IslamiApi\ApiClient::class, function ($app) {
            return new Services\IslamiApi\ApiClient();
        });

        $this->app->singleton(QuranServiceInterface::class, function ($app) {
            $serviceClass = config('quran.service', Services\IslamiApi\QuranService::class);
            if ($serviceClass === Services\IslamiApi\QuranService::class) {
                return new Services\IslamiApi\QuranService($app->make(Services\IslamiApi\ApiClient::class));
            }
            return $app->make($serviceClass);
        });

        $this->app->singleton(Services\IslamiApi\QuranService::class, function ($app) {
            return $app->make(QuranServiceInterface::class);
        });
    }

    public function boot(): void
    {
        // Register Views with namespace 'quran::'
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'quran');

        // Register Routes
        $this->registerRoutes();

        // Console Commands & Publishable Assets
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);

            // Publish Config
            $this->publishes([
                __DIR__ . '/../config/quran.php' => config_path('quran.php'),
            ], 'quran-config');

            // Publish Views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/quran'),
            ], 'quran-views');

            // Publish Assets (CSS, JS, Fonts)
            $this->publishes([
                __DIR__ . '/../resources/css' => public_path('vendor/quran/css'),
                __DIR__ . '/../resources/js' => public_path('vendor/quran/js'),
                __DIR__ . '/../resources/fonts' => public_path('vendor/quran/fonts'),
            ], 'quran-assets');
        }
    }

    protected function registerRoutes(): void
    {
        $mode = config('quran.routing_mode', 'prefix');
        $middleware = config('quran.middleware', ['web']);

        if ($mode === 'domain' && config('quran.domain')) {
            $rawDomain = config('quran.domain');
            $cleanDomain = preg_replace('#^https?://#', '', $rawDomain);
            $quranDomain = explode(':', $cleanDomain)[0];

            Route::middleware($middleware)
                ->domain($quranDomain)
                ->group(__DIR__ . '/../routes/web.php');

            if (app()->environment('local', 'development')) {
                foreach (['quran.lvh.me', 'quran.test', 'quran.localhost'] as $devDomain) {
                    if ($devDomain !== $quranDomain) {
                        Route::middleware($middleware)
                            ->domain($devDomain)
                            ->group(__DIR__ . '/../routes/web.php');
                    }
                }
            }
        } else {
            $prefix = config('quran.prefix', 'quran');
            Route::middleware($middleware)
                ->prefix($prefix)
                ->group(__DIR__ . '/../routes/web.php');
        }
    }
}