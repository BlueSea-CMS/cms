<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\Command;
use BlueSea\Cms\Facades\PageCache;
use Illuminate\Filesystem\Filesystem;

class CacheServerConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bluesea:server-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Server Configuration File';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating config file');
        $this->initializeConfig();
        $this->checkFile();
        $this->buildConfig();
    }

    public function initializeConfig()
    {
        if(!file_exists(config_path('bluesea.php')))
        {
            $this->warn('bluesea.php config file not found');
            $this->warn('Will be using default settings');

            $config = require $this->resourcePath('config/bluesea.php');
        }
        $this->replace = [
            'DummyFolder' => config('bluesea.cache.folder', $config['cache']['folder']),
            'DummyIndex' => config('bluesea.cache.index', $config['cache']['index']),
        ];
    }

    public function buildConfig()
    {
        $stub = $this->files->get($this->getStub());

        $stub = str_replace(array_keys($this->replace), array_values($this->replace), $stub);

        $this->files->put($this->rootPath('nginx.conf'), $stub, true);
    }

    public function checkFile()
    {
        if(file_exists($this->rootPath('nginx.conf')))
        {
            $this->warn('Config file found. This will overwrite your existing configuration file');
        }

        if(!file_exists($this->getStub()))
        {
            return $this->error('Stub Not Found');
        }

        $stub = $this->getStub();
    }

    public function rootPath($res = '')
    {
        return app_path('../' . $res);
    }

    public function getStub()
    {
        return $this->resourcePath('server/nginx.conf');
    }

    public function resourcePath($res = '')
    {
        return __DIR__ . '../../../resources/' . $res;
    }
}
