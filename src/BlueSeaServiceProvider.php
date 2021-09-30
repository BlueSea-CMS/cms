<?php

namespace BlueSea\Cms;

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
use BlueSea\Cms\Console\Commands\PublishThemes;
use BlueSea\Cms\Views\Components\AppTemplate;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;

class BlueSeaServiceProvider extends ServiceProvider
{
    protected $files;


    public function __construct($app)
    {
        parent::__construct($app);
        $this->files = new Filesystem;
    }
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
        // $files = [
        //     'AnonymousComments',
        //     'Blocks',
        //     'Comments',
        //     'MediaFiles'
        // ];

        // foreach($files as $file)
        // {
        //     $stub = $this->files->get($this->getMigrationStub());

        //     $publishes = $this->files->get($this->resourcePath("migrations/{$file}.stub"));

        //     $replaces = [
        //         'DummyClass' => "Create{$file}Table",
        //         'dummy_table' => "bluesea_" . Str::snake($file),
        //         'DummySchema' => $publishes,
        //     ];

        //     $output = str_replace(array_keys($replaces), array_values($replaces), $stub);

        //     $this->files->put(database_path('migrations/' . date('Y_m_d_His') . '_' . Str::snake("Create{$file}Table").'.php'), $output);

        //     // $publishes[$file] = database_path('migrations/' . date('Y_m_d_His') . '_' . pathinfo($file, PATHINFO_FILENAME) . '.php');
        // }

        // $this->publishes($publishes, 'bluesea-migration');
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
            PublishThemes::class,
        ]);
    }

    public function getMigrationStub()
    {
        return $this->resourcePath('migrations/migration.plain.stub');
    }

    public function resourcePath($res)
    {
        return __DIR__ . '/resources/' . $res;
    }
}
