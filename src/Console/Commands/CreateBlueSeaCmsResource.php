<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateBlueSeaCmsResource extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bluesea:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates views for a module';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    public function publishVendorViews()
    {
        $files = scandir($this->resourcePath('vendor/'));

        array_splice($files, array_search('.', $files), 1);
        array_splice($files, array_search('..', $files), 1);

        if(!is_dir(resource_path('/views/vendor/bluesea/cms/')))
        {
            mkdir(resource_path('/views/vendor/bluesea/cms/'), 0777, true);
        }

        foreach($files as $file)
        {
            $dest = resource_path('views/vendor/bluesea/cms/' . $file);
            if(!file_exists($dest))
            {
                $src = $this->resourcePath('vendor/' . $file);
                if(copy($src, $dest))
                {
                    if (! $this->output->getFormatter()->hasStyle('warning')) {
                        $style = new OutputFormatterStyle('yellow');
                        $this->output->getFormatter()->setStyle('warning', $style);
                    }

                    $message = '<info>Copied</info> <warning>' . basename($src) . '</warning> <info>></info> <warning>' . $dest . '</warning>';
                    $this->output->writeln($message);
                }
                else
                {
                    $this->error('Failed to publish views');
                }
            }
        }
    }

    public function handle()
    {
        $name = $this->getNameInput();

        if($name == null)
        {
            return $this->publishVendorViews();
        }

        $resources = [
            'index',
            'show',
        ];

        foreach($resources as $resource)
        {

            $resource .= '.blade.php';

            $path = $this->getPath($name . '/' . $resource);
            if(!$this->files->exists($path))
            {
                $this->makeDirectory($path);
                $this->files->put($path, $this->files->get($this->getStub()));

                $this->info(sprintf("%s in %s/%s created successfully.", $this->type, strtolower($name), $resource));
            } else {
                $this->error(sprintf("%s in %s/%s already exists.", $this->type, strtolower($name), $resource));
            }
        }

    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = 'views/' . strtolower($name);

        return resource_path($name);
    }

    public function resourcePath($res = '')
    {
        return __DIR__ . '../../../resources/' . $res;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the class'],
        ];
    }

    public function getDefinition()
    {
        $definition = parent::getDefinition();

        $definition->addOption(new InputOption('--controller', '-c', InputOption::VALUE_NONE, 'Adds Media Collection'));
        $definition->addOption(new InputOption('--media', '-M', InputOption::VALUE_NONE, 'Adds Media Collection'));
        $definition->addOption(new InputOption('--block', '-B', InputOption::VALUE_NONE, 'Adds Block Collection'));
        $definition->addOption(new InputOption('--translation', '-T', InputOption::VALUE_NONE, 'Adds Translation Collection'));
        $definition->addOption(new InputOption('--comment', '-C', InputOption::VALUE_NONE, 'Adds Comment Collection'));
        $definition->addOption(new InputOption('--anonymousComment', '-AC', InputOption::VALUE_NONE, 'Adds Anonymous Comment Collection'));
        $definition->addOption(new InputOption('--all', '-*', InputOption::VALUE_NONE, 'Adds All Feature Modules'));

        return $definition;
    }

    public function getStub()
    {
        return __DIR__ . '/stubs/views/view.plain.stub';
    }

}
