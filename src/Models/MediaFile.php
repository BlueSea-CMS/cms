<?php

namespace BlueSea\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $table = 'bluesea_media_files';
    /**
     * Get the owner that owns the File
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        $this->morphTo();
    }
}
