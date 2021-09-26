<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
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

    public function handle()
    {
        $name = $this->getNameInput();

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

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
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
