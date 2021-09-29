<?php

namespace BlueSea\Cms\Contracts;

use Closure;
use Illuminate\Support\Facades\Route;
use BlueSea\Cms\Controllers\BluesSeaController;

class BlueSeaCmsService
{
    /**
     * Generate Administration Routes for CMS
     *
     * @param array $params
     * @return void
     */
    public function routes($params = [], Closure $closure)
    {
        Route::group($params, function() {

            Route::get('/', [
                'as' => '',
                'uses' => BluesSeaController::class . '@index',
            ]);

            Route::post('/', [
                'as' => '.store',
                'uses' => BluesSeaController::class . '@store',
            ]);

            Route::put('/', [
                'as' => '.update',
                'uses' => BluesSeaController::class . '@update',
            ]);

            Route::delete('/', [
                'as' => '.delete',
                'uses' => BluesSeaController::class . '@destroy',
            ]);

        });

        if(isset($params['as']))
        {
            $params['as'] .= '.';
        }

        Route::group($params, $closure);

    }

}
