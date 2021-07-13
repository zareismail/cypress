<?php

namespace Zareismail\Cypress\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Zareismail\Cypress\Cypress;

class TestCase extends BaseTestCase
{ 
    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        Cypress::replaceComponents([]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Zareismail\Cypress\CoreServiceProvider',
            'Zareismail\Cypress\Tests\ServiceProvider',
        ];
    } 
}