<?php

namespace BlueSea\Cms\Traits;

use BlueSea\Cms\Cms\Models\Comment;

trait HasComments
{
    /**
     * Get all of the files for the Eloquent Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'owner');
    }
}
