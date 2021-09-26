<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class CreateBlueSeaCmsModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bluesea:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates New BlueSea CMS Module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createModel();
        $this->createController();
        $this->createViews();
        $this->establishRoutes();
    }

    public function getFlags()
    {
        if((bool) $this->option('module'))
        {
            return $this->info($this->option('module'));
        }
    }

    public function createModel()
    {
        $this->info('Creating Model');
        $this->runCommand(CreateBlueSeaCmsModel::class, [
            'name' => $this->argument('name'),
            '--all' => $this->option('all'),
            '--block' => $this->option('block'),
            '--media' => $this->option('media'),
            '--translation' => $this->option('translation'),
            '--anonymousComment' => $this->option('anonymousComment'),
            '--comment' => $this->option('comment'),
        ], $this->getOutput());

        $this->runCommand(CreateBlueSeaCmsMigrations::class, [
            'name' => $this->argument('name'),
        ], $this->getOutput());
    }

    public function createController()
    {
        $this->info('Creating Controller');
        $this->runCommand(CreateBlueSeaCmsController::class, [
            'name' => $this->option('controller') ?: $this->argument('name') . 'Controller',
            '--model' => $this->argument('name'),
        ], $this->getOutput());
    }

    public function createViews()
    {
        $this->info('Generating Views');
        $this->runCommand(CreateBlueSeaCmsResource::class, [
            'name' => $this->argument('name'),
            '--controller' => $this->option('controller') ?: $this->argument('name') . 'Controller',
        ], $this->getOutput());
    }

    public function establishRoutes()
    {
        $this->info('Establishing Routes');
        $this->runCommand(EstablishRoute::class, [
            '--controller' => $this->option('controller') ?: $this->argument('name') . 'Controller',
        ], $this->getOutput());

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model class'],
        ];
    }

    public function getDefinition()
    {
        $definition = parent::getDefinition();

        $definition->addOption(new InputOption('--controller', '-c', InputOption::VALUE_OPTIONAL, 'Custom Controller name'));
        $definition->addOption(new InputOption('--model', '-m', InputOption::VALUE_OPTIONAL, 'Define model class name'));
        $definition->addOption(new InputOption('--media', '-M', InputOption::VALUE_NONE, 'Adds Media Collection'));
        $definition->addOption(new InputOption('--block', '-B', InputOption::VALUE_NONE, 'Adds Block Collection'));
        $definition->addOption(new InputOption('--translation', '-T', InputOption::VALUE_NONE, 'Adds Translation Collection'));
        $definition->addOption(new InputOption('--comment', '-C', InputOption::VALUE_NONE, 'Adds Comment Collection'));
        $definition->addOption(new InputOption('--anonymousComment', '-AC', InputOption::VALUE_NONE, 'Adds Anonymous Comment Collection'));
        $definition->addOption(new InputOption('--all', '-*', InputOption::VALUE_NONE, 'Adds All Feature Modules'));

        return $definition;
    }

    /**
     * Get all of the context passed to the command.
     *
     * @return array
     */
    protected function context()
    {
        return collect($this->option())->only([
            'all',
            'controller',
            'block',
            'media',
            'translation',
            'anonymousComment',
            'comment',
            'ansi',
            'no-ansi',
            'no-interaction',
            'quiet',
            'verbose',
        ])->filter()->mapWithKeys(function ($value, $key) {
            return ["--{$key}" => $value];
        })->all();
    }

}
