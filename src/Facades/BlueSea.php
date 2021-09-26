<?php

namespace BlueSea\Cms\Facades;

use Illuminate\Support\Facades\Facade;
use BlueSea\Cms\Contracts\BlueSeaCmsService;

/**
 * @method static void route($params = [])
 */
class BlueSea extends Facade
{
    public static function getFacadeAccessor()
    {
        return BlueSeaCmsService::class;
    }
}
