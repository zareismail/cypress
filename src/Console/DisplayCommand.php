<?php

namespace Zareismail\Cypress\Console;
 
use Illuminate\Console\GeneratorCommand;  

class DisplayCommand extends GeneratorCommand
{
    use ResolvesStubPath;
    use ResolvesViewName;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cypress:display';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view for the layout.';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View'; 

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/cypress/display.stub');
    } 

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->viewPath($this->getView().'.blade.php');
    }
}
