<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class PublishThemes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bluesea:themes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish BlueSea CMS Themes';

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
        $this->publishThemes();
    }

    public function publishThemes()
    {
        $files = $this->getFiles($this->resourcePath('themes'));

        foreach($files as $file)
        {
            $output = resource_path('views/vendor/bluesea/cms/' . dirname($file));
            if(!is_dir($output))
            {
                mkdir($output, 0777, true);
            }
            if(copy($this->resourcePath($file), resource_path('views/vendor/bluesea/cms/' . $file)))
            {
                $this->printLineFile('views/vendor/bluesea/cms/' . $file);
            }
        }
    }

    public function printLineFile($file)
    {

        if (! $this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->output->getFormatter()->setStyle('warning', $style);
        }

        $styled = "<info>Published theme file to</info> <warning>{$file}</warning>";
        $this->output->writeln($styled);
    }

    public function getFiles($path, $collection = [])
    {
        $files = scandir($path);

        array_splice($files, array_search('.', $files), 1);
        array_splice($files, array_search('..', $files), 1);

        foreach($files as $file)
        {
            $sourcePath = $path . '/' . $file;
            if(!is_dir($sourcePath))
            {
                array_push($collection, str_replace($this->resourcePath(), '', $sourcePath));
            }
            else
            {
                $collection = $this->getFiles($sourcePath, $collection);
            }
        }

        return $collection;
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
