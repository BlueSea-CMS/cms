<?php

return [

    'theme' => 'default',

    'cache' => [
        'folder' => 'bluesea',
        'index' => 'cache_index',
    ],
    'db' => [
        'files' => [
            'model' => Jefte\Models\File::class,
            'table' => 'media_files',
        ]
    ]
];
