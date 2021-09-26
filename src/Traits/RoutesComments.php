<?php

namespace BlueSea\Cms\Traits;

use Closure;
use BlueSea\Cms\Controllers\CommentsController;

trait RoutesComments
{
    public static function routesComments($params, Closure $closure = null)
    {
        CommentsController::routes($params, $closure);
    }
}
