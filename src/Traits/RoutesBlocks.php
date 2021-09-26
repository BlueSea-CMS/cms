<?php

namespace BlueSea\Cms\Traits;

use Closure;
use BlueSea\Cms\Controllers\BlocksController;

trait RoutesBlocks
{
    public static function routesBlocks($params, Closure $closure = null)
    {
        BlocksController::routes($params, $closure);
    }
}
