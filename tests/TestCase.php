<?php

namespace Ako\Shorturl\Tests;

abstract class TestCase extends  \Orchestra\Testbench\TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'shorturl');
        $app['config']->set('database.connections.shorturl', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return ['Ako\Shorturl\ShorturlServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Shorturl' => 'Ako\Shorturl\Facades\Shorturl'
        ];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../migrations/');
    }
}
