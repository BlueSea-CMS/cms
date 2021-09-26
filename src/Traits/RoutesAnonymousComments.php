<?php

namespace BlueSea\Cms\Traits;

use Closure;
use BlueSea\Cms\Controllers\AnonymousCommentController;

trait RoutesAnonymousComments
{
    public static function routeAnonymousComments($params, Closure $closure = null)
    {
        AnonymousCommentController::routes($params, $closure);
    }
}
