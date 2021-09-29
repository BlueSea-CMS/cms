<?php

namespace BlueSea\Cms;

use App\View\Components\AppTemplate;
use Illuminate\Support\ServiceProvider;
use BlueSea\Cms\Console\Commands\CreateBlueSeaCmsModel;
use BlueSea\Cms\Console\Commands\CreateBlueSeaCmsModule;
use BlueSea\Cms\Console\Commands\InstallBlueSeaCms;
use BlueSea\Cms\Console\Commands\ClearCache;
use BlueSea\Cms\Console\Commands\CacheServerConfig;
use BlueSea\Cms\Console\Commands\CreateBlueSeaCmsController;
use BlueSea\Cms\Console\Commands\CreateBlueSeaCmsResource;
use BlueSea\Cms\Console\Commands\EstablishRoute;
use BlueSea\Cms\Console\Commands\CreateBlueSeaCmsMigrations;
use Illuminate\Support\Facades\Blade;

class BlueSeaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPublishables();
        $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom($this->resourcePath('views'), 'bluesea-cms');
    }

    public function registerPublishables()
    {
        $this->registerConfig();
        $this->registerMigrations();
    }

    public function registerConfig()
    {
        $this->publishes([
            $this->resourcePath('config/bluesea.php') => config_path('bluesea.php')
        ], 'bluesea-config');
    }

    public function registerMigrations()
    {
        $publishes = [];

        foreach(glob($this->resourcePath('migrations') . '/*', GLOB_NOSORT) as $file)
        {
            $publishes[$file] = database_path('migrations/' . date('Y_m_d_His') . '_' .  basename($file));
        }

        $this->publishes($publishes, 'bluesea-migration');
    }

    public function registerCommands()
    {
        $this->commands([
            InstallBlueSeaCms::class,
            CreateBlueSeaCmsController::class,
            CreateBlueSeaCmsModel::class,
            CreateBlueSeaCmsModule::class,
            CreateBlueSeaCmsResource::class,
            ClearCache::class,
            CacheServerConfig::class,
            EstablishRoute::class,
            CreateBlueSeaCmsMigrations::class,
        ]);
    }

    public function resourcePath($res)
    {
        return __DIR__ . '/resources/' . $res;
    }
}
