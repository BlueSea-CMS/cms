<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class EstablishRoute extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bluesea:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates BlueSea CMS Routes';

    public function handle()
    {
        $this->establishRoutePath();

        $this->appendControllerRoutes();
    }

    public function establishRoutePath()
    {
        if(!file_exists($this->routePath()))
        {
            $stub = $this->files->get($this->getStub());
            $this->files->put($this->routePath(), $stub);
            $this->info('CMS route file created.');

        }

        if(file_exists($this->defaultRoutePath()))
        {
            $stub = $this->files->get($this->defaultRoutePath());

            $output = "\n\nRoute::group(['prefix' => 'cms'], function() {\n\r\trequire __DIR__ . '/cms.php';\n\n});\n";
            if(!str_contains($stub, $output))
            {
                $stub .= $output;

                $this->files->put($this->defaultRoutePath(), $stub);
                $this->info('CMS route established.');
            }
        }

    }

    public function appendControllerRoutes()
    {
        if(file_exists($this->routePath()))
        {
            if($this->option('controller') != null)
            {
                $stub = $this->files->get($this->routePath());

                $output = str_replace("<?php\n\n", "<?php\n\nuse App\\Http\\Controllers\\".$this->option('controller').";\n", $stub);

                $output .= "\n{$this->option('controller')}::routes();\n";

                $this->files->put($this->routePath(), $output, true);
            }

        } else {
            $this->error('Failed to append controller routes');
        }
    }

    public function getStub()
    {
        return __DIR__ . '/stubs/routes/route.stub';
    }

    public function routePath()
    {
        return app_path('../routes/cms.php');
    }

    public function getDefinition()
    {
        $definition = parent::getDefinition();

        $definition->addOption(new InputOption('--controller', '-c', InputOption::VALUE_OPTIONAL, 'Append routes for defined controller'));
        $definition->addOption(new InputOption('--all', '-*', InputOption::VALUE_OPTIONAL, 'All'));

        return $definition;
    }

    public function defaultRoutePath()
    {
        return app_path('../routes/web.php');
    }

}
