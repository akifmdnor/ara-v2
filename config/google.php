<?php

return [
    'maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY', ''),
        'library' => 'places',
        'callback' => 'Function.prototype',
    ],
];
