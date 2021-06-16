<?php

namespace Zareismail\Cypress\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ComponentCommand extends GeneratorCommand
{
    use ResolvesStubPath;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cypress:component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';  

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $layout = $this->option('layout');

        $layoutNamespace = $this->getLayoutNamespace();

        if (is_null($layout)) {
            $layout = \Zareismail\Cypress\Layouts\Clean::class;
        } elseif (! Str::startsWith($layout, [
            $layoutNamespace, '\\',
        ])) {
            $layout = $layoutNamespace.$layout;
        } 

        return str_replace('{{ layout }}', $layout, parent::buildClass($name));
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/cypress/component.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Cypress';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getLayoutNamespace()
    {
        $rootNamespace = $this->laravel->getNamespace();

        return is_dir(app_path('Layouts')) ? $rootNamespace.'Layouts\\' : $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['layout', 'l', InputOption::VALUE_OPTIONAL, 'The layout class being represented.'],
        ];
    }
}
