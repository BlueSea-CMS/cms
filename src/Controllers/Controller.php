<?php

namespace BlueSea\Cms\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    protected $model;

    public static function model()
    {
        $app = static::class;

        $model = (new $app())->model;

        return (new $model);
    }

    public static function routes($param = [])
    {
        if(!isset($param['prefix']))
        {
            $param['prefix'] = Str::slug(static::model()->getTable());
        }

        if(!isset($param['as']))
        {
            $param['as'] = Str::slug(static::model()->getTable());
        }

        if(!isset($param['slug']))
        {
            $param['slug'] = static::model()->getKeyName();
        }

        Route::group($param, function() use($param) {

            Route::get('/', [
                'as' => '',
                'uses' => static::class . '@index',
            ]);

            Route::get('/{'. $param['slug'] .'}', [
                'as' => '.show',
                'uses' => static::class . '@show',
            ]);

            Route::post('/', [
                'as' => '.create',
                'uses' => static::class . '@store',
            ]);

            Route::put('/{'. $param['slug'] .'}', [
                'as' => '.update',
                'uses' => static::class . '@update',
            ]);

            Route::delete('/{'. $param['slug'] .'}', [
                'as' => '.delete',
                'uses' => static::class . '@destroy',
            ]);

            $param['prefix'] = '{'. $param['slug'] .'}';
            $param['as'] = '';

            Route::group($param, function() use ($param) {

                if(method_exists(static::class, 'routesMediaFiles'))
                {
                    static::routesMediaFiles([]);
                }

                if(method_exists(static::class, 'routeAnonymousComments'))
                {
                    static::routeAnonymousComments([]);
                }

                if(method_exists(static::class, 'routesBlocks'))
                {
                    static::routesBlocks([]);
                }

                if(method_exists(static::class, 'routesTranslations'))
                {
                    static::routesTranslations([]);
                }

                if(method_exists(static::class, 'routesComments'))
                {
                    static::routesComments([]);
                }
            });
        });

    }
}
