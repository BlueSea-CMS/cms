<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CreateBlueSeaCmsMigrations extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bluesea:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Database Migration';

    public function handle()
    {
        $stub = $this->files->get($this->getStub());

        $outputName = sprintf('Create%sTable', Str::plural($this->argument('name'), 2));
        $replace['DummyClass'] = $outputName;
        $replace['dummy_table'] = Str::snake(Str::plural($this->argument('name'), 2));

        $output = str_replace(array_keys($replace), array_values($replace), $stub);

        $this->files->put($this->outputPath(), $output, true);

        $this->info('Migration Created');
    }

    public function getStub()
    {
        return __DIR__ . '/stubs/migrations/migration.plain.stub';
    }

    public function outputPath()
    {
        $outputName = Str::snake(sprintf('Create%sTable', Str::plural($this->argument('name'), 2)));
        return database_path('migrations/' . date('Y_m_d_His') . '_' . $outputName . '.php');
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

}
