<?php

namespace BlueSea\Cms\Traits;

use BlueSea\Cms\Models\MediaFile;

trait HasMediaFiles
{
    /**
     * Get all of the files for the Eloquent Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->morphMany(MediaFile::class, 'owner');
    }
}
