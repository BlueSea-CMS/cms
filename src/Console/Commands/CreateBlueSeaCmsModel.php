<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateBlueSeaCmsModel extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bluesea:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new BlueSea CMS Model';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Models';
    }

    public function buildTraits($replace)
    {
        $traits = '';
        $traitClass = '';

        if($this->option('media') || $this->option('all'))
        {
            $traits.= ', HasMediaFiles';
            $traitClass .= "use BlueSea\Cms\Traits\HasMediaFiles;\n";
        }

        if($this->option('block') || $this->option('all'))
        {
            $traits.= ', HasBlocks';
            $traitClass .= "use BlueSea\Cms\Traits\HasBlocks;\n";
        }

        if($this->option('translation') || $this->option('all'))
        {
            $traits.= ', HasTranslations';
            $traitClass .= "use BlueSea\Cms\Traits\HasTranslations;\n";
        }

        if($this->option('comment') || $this->option('all'))
        {
            $traits.= ', HasComments';
            $traitClass .= "use BlueSea\Cms\Traits\HasComments;\n";
        }

        if($this->option('anonymousComment') || $this->option('all'))
        {
            $traits.= ', HasAnonymousComments';
            $traitClass .= "use BlueSea\Cms\Traits\HasAnonymousComments;\n";
        }

        $replace["use DummyTraitClass;\n"] = $traitClass;
        $replace[", DummyTrait"] = $traits;

        return $replace;
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        $replace["use {$controllerNamespace};\n"] = '';

        $replace = $this->buildTraits($replace);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
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
        return __DIR__ . '/stubs/models/model.plain.stub';
    }

}
