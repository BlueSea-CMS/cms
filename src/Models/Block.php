<?php

namespace BlueSea\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'bluesea_blocks';

    protected $fillable = [
        'owner_type',
        'owner_id',
        'template',
        'data',
        'draft_content',
        'published_content',
    ];

    protected $casts = [
        'data' => 'json'
    ];

    /**
     * Get the owner that owns the File
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        $this->morphTo();
    }

    public function renderBlock()
    {
        if($this->data != null)
        {
            return str_replace(array_keys($this->data), array_values($this->data), $this->draft_content);
        }
        return $this->draft_content;
    }
    public function publish()
    {
        $this->published_content = $this->renderBlock();

        $this->save();
    }
}
