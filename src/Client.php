<?php
namespace Ranium\LaravelFixerio;

use Ranium\Fixerio\Client as BaseClient;

/**
 * Client class for Fixerio
 *
 * @author Abbas Ali <abbas@ranium.in>
 */
class Client extends BaseClient
{
    /**
     * Whether to cache the results or not
     *
     * @var boolean
     */
    protected $cacheResult = false;

    /**
     * Creates and executes a command for an operation by name.
     *
     * We are overriding \GuzzleHttp\Command\ServiceClient::__call()
     * so that we can cache the responses.
     *
     * @param string $name Name of the command to execute.
     * @param array  $args Arguments to pass to the getCommand method.
     *
     * @return GuzzleHttp\Promise\ResultInterface|GuzzleHttp\Promise\PromiseInterface
     * @see \GuzzleHttp\Command\ServiceClientInterface::getCommand
     */
    public function __call($name, array $args)
    {
        // If cache is enabled, then get the result from cache
        if ($this->cacheResult) {
            $key = $this->getCacheKey($name, $args);

            return cache()->remember(
                $key,
                config('fixerio.cache.expire_after'),
                function () use ($name, $args) {
                    return parent::__call($name, $args);
                }
            );
        }

        // No caching, call the parent's __call() method
        return parent::__call($name, $args);
    }

    /**
     * Method to construct the cache key.
     *
     * Any change in the arguments or fixerio config
     * will bust the cache for the given method.
     *
     * @param string $name Name of the method being called
     * @param array  $args Arguments being passed to the method
     *
     * @return string Cache key
     */
    private function getCacheKey($name, $args)
    {
        // Cache key will be and hash of args and config (prefixed with method name)
        return $name . '_' . md5(
            json_encode($args) .
            json_encode(config('fixerio'))
        );
    }

    /**
     * Method to disable the caching of results
     *
     * @return void
     */
    public function disableCache()
    {
        $this->cacheResult = false;
    }

    /**
     * Method to enable the caching of results
     *
     * @return void
     */
    public function enableCache()
    {
        $this->cacheResult = true;
    }
}
