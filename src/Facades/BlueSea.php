<?php

namespace BlueSea\Cms\Facades;

use Illuminate\Support\Facades\Facade;
use BlueSea\Cms\Contracts\BlueSeaCmsService;

/**
 * @method static void route($params = [])
 */
class BlueSeaCms extends Facade
{
    public static function getFacadeAccessor()
    {
        return BlueSeaCmsService::class;
    }
}
