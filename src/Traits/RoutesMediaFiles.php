<?php

namespace BlueSea\Cms\Traits;

use Closure;
use BlueSea\Cms\Controllers\MediaFilesController;

trait RoutesMediaFiles
{
    public static function routesMediaFiles($params, Closure $closure = null)
    {
        MediaFilesController::routes($params, $closure);
    }
}
