<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateBlueSeaCmsController extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bluesea:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new BlueSea CMS Controller';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controllers';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    public function buildTraits($replace)
    {
        $traits = '';
        $traitClass = '';

        if($this->option('media') || $this->option('all'))
        {
            $traits.= strlen($traits) > 0 ? ', RoutesMediaFiles' : 'use RoutesMediaFiles';
            $traitClass .= "use BlueSea\Cms\Traits\RoutesMediaFiles;\n";
        }

        if($this->option('block') || $this->option('all'))
        {
            $traits.= strlen($traits) > 0 ? ', RoutesBlocks' : 'use RoutesBlocks';
            $traitClass .= "use BlueSea\Cms\Traits\RoutesBlocks;\n";
        }

        if($this->option('translation') || $this->option('all'))
        {
            $traits.= strlen($traits) > 0 ? ', RoutesTranslations' : 'use RoutesTranslations';
            $traitClass .= "use BlueSea\Cms\Traits\RoutesTranslations;\n";
        }

        if($this->option('comment') || $this->option('all'))
        {
            $traits.= strlen($traits) > 0 ? ', RoutesComments' : 'use RoutesComments';
            $traitClass .= "use BlueSea\Cms\Traits\RoutesComments;\n";
        }

        if($this->option('anonymousComment') || $this->option('all'))
        {
            $traits.= strlen($traits) > 0 ? ', RoutesAnonymousComments' : 'use RoutesAnonymousComments';
            $traitClass .= "use BlueSea\Cms\Traits\RoutesAnonymousComments;\n";
        }

        $traits .= strlen($traits) > 0 ? ";\n" : '';

        $replace["use DummyTraitClass;\n"] = $traitClass;
        $replace["use DummyTrait;"] = $traits;

        if($this->option('all'))
        {
            $replace['dummyView'] = strtolower($this->option('model'));
        }else {
            $replace['return view(\'dummyView.index\');'] = '';
            $replace['return view(\'dummyView.show\');'] = '';
        }

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

        $replace = $this->buildTraits([]);

        $replace["use {$controllerNamespace};\n"] = '';

        $replace["protected \$model = DummyModel;\n"] = $this->option('model') ? sprintf("protected \$model = \App\Models\%s::class;\n", $this->option('model')) : '';
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

        $definition->addOption(new InputOption('--model', '-m', InputOption::VALUE_OPTIONAL, 'Defines Model For Controller'));
        $definition->addOption(new InputOption('--media', '-M', InputOption::VALUE_NONE, 'Adds Media Routes'));
        $definition->addOption(new InputOption('--block', '-B', InputOption::VALUE_NONE, 'Adds Block Routes'));
        $definition->addOption(new InputOption('--translation', '-T', InputOption::VALUE_NONE, 'Adds Translation Routes'));
        $definition->addOption(new InputOption('--comment', '-C', InputOption::VALUE_NONE, 'Adds Comment Routes'));
        $definition->addOption(new InputOption('--anonymousComment', '-AC', InputOption::VALUE_NONE, 'Adds Anonymous Comment Routes'));
        $definition->addOption(new InputOption('--all', '-*', InputOption::VALUE_NONE, 'Adds All Feature Routes'));

        return $definition;
    }

    public function getStub()
    {
        return __DIR__ . '/stubs/controllers/controller.plain.stub';
    }

}
