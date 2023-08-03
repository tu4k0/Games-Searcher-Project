<?php

return [
    'credentials' => [
        'client_id' => env('TWITCH_CLIENT_ID', ''),
        'client_secret' => env('TWITCH_CLIENT_SECRET', ''),
    ],

    'cache_lifetime' => env('IGDB_CACHE_LIFETIME', 3600),

    'webhook_path' => 'igdb-webhook/handle',

    'webhook_secret' => env('IGDB_WEBHOOK_SECRET'),
];
