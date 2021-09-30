<?php

namespace BlueSea\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Theme extends Model
{
    protected $table = 'bluesea_themes';

    protected $fillable = [
        'name',
        'prefix',
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

    public static function booted()
    {
        static::creating(function($data) {
            $data->prefix = str_replace('_', '.', Str::snake($data->name));
        });
    }
}
