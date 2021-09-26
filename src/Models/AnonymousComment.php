<?php

namespace BlueSea\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class AnonymousComment extends Model
{
    protected $table = 'bluesea_anonymous_comments';

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
