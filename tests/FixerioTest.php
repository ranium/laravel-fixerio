<?php
namespace Ranium\LaravelFixerio\Test;

use Illuminate\Support\Facades\Cache;

class FixerioTest extends TestCase
{
    public function testItCanResolveFixerio()
    {
        $this->assertInstanceOf(
            \Ranium\LaravelFixerio\Client::class,
            app(\Ranium\LaravelFixerio\Client::class)
        );
    }

    public function testItCanGetLatestRates()
    {
        $fixerio = app(\Ranium\LaravelFixerio\Client::class);

        $latestRates = $fixerio->latest();

        $this->assertFixerioResponse($latestRates);
    }

    public function testItCanGetHistoricalRates()
    {
        $fixerio = app(\Ranium\LaravelFixerio\Client::class);

        $historicalRates = $fixerio->historical(
            [
                'date' => '2019-01-01',
            ]
        );

        $this->assertFixerioResponse($historicalRates);
    }

    /**
     * @environment-setup useCache
     */
    public function testItCanCacheFixerioResponse()
    {
        Cache::shouldReceive('remember')
                    ->once();

        $fixerio = app(\Ranium\LaravelFixerio\Client::class);

        $fixerio->latest();
    }

    /**
     * Define environment setup for enabling cache
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function useCache($app)
    {
        $app->config->set('fixerio.cache.enabled', true);
    }

    private function assertFixerioResponse($response)
    {
        $this->assertTrue($response['success']);
        $this->assertIsArray($response['rates']);
    }
}
