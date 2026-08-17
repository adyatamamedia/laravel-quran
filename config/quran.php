<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Quran Routing Configuration
    |--------------------------------------------------------------------------
    | 'mode': 'prefix' (e.g. yourdomain.com/quran) or 'domain' (e.g. quran.yourdomain.com)
    */
    'routing_mode' => env('QURAN_ROUTING_MODE', 'prefix'),
    'prefix'       => env('QURAN_ROUTE_PREFIX', 'quran'),
    'domain'       => env('QURAN_DOMAIN', null),
    'middleware'   => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Islami API Client Configuration
    |--------------------------------------------------------------------------
    */
    'api' => [
        'url'             => env('ISLAMI_API_URL', 'https://aswaja.tama.my.id/api/v1'),
        'key'             => env('ISLAMI_API_KEY', ''),
        'timeout'         => (int) env('ISLAMI_API_TIMEOUT', 10),
        'connect_timeout' => (int) env('ISLAMI_API_CONNECT_TIMEOUT', 3),
        'cache_enabled'   => (bool) env('ISLAMI_API_CACHE', true),
        'cache_ttl'       => [
            'surahs' => 86400 * 7,    // 7 days
            'surah'  => 86400 * 7,    // 7 days
            'verse'  => 86400 * 7,    // 7 days
            'tafsir' => 86400 * 7,    // 7 days
            'mushaf' => 86400 * 30,   // 30 days
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */
    'features' => [
        'tahlil' => true,
        'wirid'  => true,
        'maulid' => true,
        'audio'  => true,
        'tafsir' => true,
    ],
];
