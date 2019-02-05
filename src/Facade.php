<?php
namespace Ranium\LaravelFixerio;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * Facade for LaravelFixerio
 *
 * @author Abbas Ali <abbas@ranium.in>
 */
class Facade extends IlluminateFacade
{
    /**
     * Method to get facade accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-fixerio';
    }
}
