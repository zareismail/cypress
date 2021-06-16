<?php

namespace Zareismail\Cypress\Console;

use Illuminate\Console\GeneratorCommand;  

class LayoutCommand extends GeneratorCommand
{
    use ResolvesStubPath;
    use ResolvesViewName;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cypress:layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new layout class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Layout'; 

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        parent::handle();

        $this->callSilent('cypress:display', [
            'name' => $this->argument('name'),
        ]);
    } 

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        return str_replace('{{ viewName }}', $this->getView(), parent::buildClass($name));
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/cypress/layout.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Cypress\Layouts';
    } 
}
