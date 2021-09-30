<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
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
        if($this->argument('name') == null)
        {
            return $this->publishDefaultMigrations();
        }
        $stub = $this->files->get($this->getStub());

        $outputName = sprintf('Create%sTable', Str::plural($this->argument('name'), 2));
        $replace['DummyClass'] = $outputName;
        $replace['dummy_table'] = Str::snake(Str::plural($this->argument('name'), 2));

        $output = str_replace(array_keys($replace), array_values($replace), $stub);

        $this->files->put($this->outputPath(), $output, true);

        $this->info('Migration Created');
    }

    public function publishDefaultMigrations()
    {

        $files = [
            'AnonymousComments',
            'Blocks',
            'Comments',
            'MediaFiles'
        ];

        foreach($files as $file)
        {
            $stub = $this->files->get($this->getMigrationStub());

            $publishes = $this->files->get($this->resourcePath("migrations/{$file}.stub"));

            $replaces = [
                'DummyClass' => "Create{$file}Table",
                'dummy_table' => "bluesea_" . Str::snake($file),
                'DummySchema' => $publishes,
            ];

            $output = str_replace(array_keys($replaces), array_values($replaces), $stub);

            $dest = database_path('migrations/' . date('Y_m_d_His') . '_' . Str::snake("Create{$file}Table").'.php');

            if($this->files->put($dest, $output))
            {
                $this->info(basename($dest) . ' migration created');
            }

            // $publishes[$file] = database_path('migrations/' . date('Y_m_d_His') . '_' . pathinfo($file, PATHINFO_FILENAME) . '.php');
        }
        return;
    }


    public function getMigrationStub()
    {
        return $this->resourcePath('migrations/migration.plain.stub');
    }

    public function getStub()
    {
        return __DIR__ . '/stubs/migrations/migration.plain.stub';
    }

    public function resourcePath($res = '')
    {
        return __DIR__ . '../../../resources/' . $res;
    }

    public function outputPath()
    {
        $outputName = Str::snake(sprintf('Create%sTable', Str::plural($this->argument('name'), 2)));
        return database_path('migrations/' . date('Y_m_d_His') . '_' . $outputName . '.php');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the model class'],
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

}
