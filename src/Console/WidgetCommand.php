<?php

namespace Zareismail\Cypress\Console;

use Illuminate\Console\GeneratorCommand;  

class WidgetCommand extends GeneratorCommand
{
    use ResolvesStubPath;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cypress:widget';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new widget class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';  

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/cypress/widget.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Cypress\Widgets';
    } 
}
