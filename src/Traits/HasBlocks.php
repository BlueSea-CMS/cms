<?php

namespace BlueSea\Cms\Traits;

use BlueSea\Cms\Models\Block;

trait HasBlocks
{
    /**
     * Get all of the files for the Eloquent Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->morphMany(Block::class, 'owner');
    }
}
