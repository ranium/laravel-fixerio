<?php
namespace Ranium\LaravelFixerio;

use Ranium\LaravelFixerio\Client as FixerioClient;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * ServiceProvider for the LaravelFixerio package
 *
 * @author Abbas Ali <abbas@ranium.in>
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // This package publishes the fixerio config file
        $this->publishes(
            [
                __DIR__.'/../config/fixerio.php' => config_path('fixerio.php'),
            ],
            'laravel-fixerio'
        );

        $this->app->alias(FixerioClient::class, 'laravel-fixerio');

        $this->app->bind(FixerioClient::class, function ($app, $params) {

            $config = $this->buildConfig($params);

            $client = FixerioClient::create($config['access_key'], $config['secure']);

            // If caching has been enabled
            if ($config['cache']['enabled']) {
                $client->enableCache();
            }

            return $client;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the default package config with the app's config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/fixerio.php', 'fixerio'
        );
    }

    /**
     * Build the fixerio config
     *
     * @param array $runtimeConfig Params/Config passed while making/resolving during runtime
     *
     * @return array Final config array to be used to build fixerio client
     */
    private function buildConfig($runtimeConfig = [])
    {
        // Merge all configs
        return array_merge($this->app['config']['fixerio'], $runtimeConfig);
    }
}
