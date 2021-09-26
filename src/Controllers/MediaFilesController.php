<?php

namespace BlueSea\Cms\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MediaFilesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function routes($params = [], Closure $closure = null)
    {
        if(!isset($params['prefix']))
        {
            $params['prefix'] = 'media-files';
        }

        Route::group($params, function($closure) {

            Route::get('/', [
                'as' => '.media-files',
                'uses' => MediaFilesController::class . '@index',
            ]);

            Route::get('/{slug}', [
                'as' => '.media-files.show',
                'uses' => MediaFilesController::class . '@show',
            ]);

            Route::post('/', [
                'as' => '.media-files.create',
                'uses' => MediaFilesController::class . '@store',
            ]);

            Route::put('/{slug}', [
                'as' => '.media-files.update',
                'uses' => MediaFilesController::class . '@update',
            ]);

            Route::delete('/{slug}', [
                'as' => '.media-files.delete',
                'uses' => MediaFilesController::class . '@destroy',
            ]);

        });
    }

}
