<?php

namespace BlueSea\Cms\Traits;

use Closure;
use BlueSea\Cms\Controllers\TranslationsController;

trait RoutesTranslations
{
    public static function routesTranslations($params, Closure $closure = null)
    {
        TranslationsController::routes($params, $closure);
    }
}
