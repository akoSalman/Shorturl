<?php

namespace Ako\Shorturl\Tests;

abstract class TestCase extends  \Orchestra\Testbench\TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'shorturl');
        $app['config']->set('database.connections.shorturl', [
            'driver'   => 'mysql',
            'database' => 'shorturl',
            'host'   => '127.0.0.1',
            'port'  => '3306',
            'username'  => 'root',
            'password' => 'mysql'
        ]);
        $app['config']->set('app.key', 'sF5r4kJy5HEcOEx3NWxUcYj1zLZLHxuu');
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