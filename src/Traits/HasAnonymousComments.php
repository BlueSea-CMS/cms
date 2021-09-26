<?php

namespace BlueSea\Cms\Traits;

use BlueSea\Cms\Models\AnonymousComment;

trait HasAnonymousComments
{
    /**
     * Get all of the files for the Eloquent Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function anonymousComments()
    {
        return $this->morphMany(AnonymousComment::class, 'owner');
    }
}
