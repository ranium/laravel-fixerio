<?php
namespace Ranium\LaravelFixerio\Test;

use Ranium\LaravelFixerio\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Set up test case
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Load the package service providers
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('fixerio.access_key', env('FIXERIO_API_KEY'));
        $app['config']->set('fixerio.secure', false);
    }
}
