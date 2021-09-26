<?php

namespace BlueSea\Cms\Traits;

use BlueSea\Cms\Http\Request;

trait HasInitialResource
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function initialIndex($request = null)
    {
        if(method_exists(self::class, 'index'))
        {
            return $this->index($request);
        }
        return view(sprintf('vendor.BlueSeaCms.%s.index', static::model()->getTable()));
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
    public function show(Request $request)
    {
        return view(sprintf('vendor.BlueSeaCms.%s.show', static::model()->getTable()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
