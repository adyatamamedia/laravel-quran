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
    'site_title'   => env('QURAN_SITE_TITLE', 'Quran Laravel Pack'),
    'version'      => env('QURAN_ASSET_VERSION', '2.2.1'),
    'middleware'   => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Service Implementation Class (Custom Driver / Service)
    |--------------------------------------------------------------------------
    | You can replace the default service with your own custom class
    | implementing Adyatama\Quran\Contracts\QuranServiceInterface.
    */
    'service' => env('QURAN_SERVICE_CLASS', \Adyatama\Quran\Services\IslamiApi\QuranService::class),
    'content_service' => env('QURAN_CONTENT_SERVICE_CLASS', \Adyatama\Quran\Services\IslamiApi\ContentService::class),

    /*
    |--------------------------------------------------------------------------
    | Islami API & Backend Endpoints Configuration
    |--------------------------------------------------------------------------
    | You can customize the base URL or specific endpoint paths per feature.
    */
    'api' => [
        'url'             => env('ISLAMI_API_URL', 'https://aswaja.tama.my.id/api/v1'),
        'key'             => env('ISLAMI_API_KEY', ''),
        'timeout'         => (int) env('ISLAMI_API_TIMEOUT', 10),
        'connect_timeout' => (int) env('ISLAMI_API_CONNECT_TIMEOUT', 3),
        'verify_ssl'      => (bool) env('ISLAMI_API_VERIFY_SSL', false),
        'cache_enabled'   => (bool) env('ISLAMI_API_CACHE', true),

        // Customizable Endpoint Paths
        'endpoints' => [
            'surahs'      => env('QURAN_EP_SURAHS', 'quran/surahs'),
            'surah'       => env('QURAN_EP_SURAH', 'quran/surahs/{number}'),
            'verse'       => env('QURAN_EP_VERSE', 'quran/surah/{surah}/ayah/{ayah}'),
            'verse_legacy'=> env('QURAN_EP_VERSE_LEGACY', 'surah/{surah}/{ayah}'),
            'tahlil'      => env('QURAN_EP_TAHLIL', 'collections/tahlil-lengkap'),
            'collections' => env('QURAN_EP_COLLECTIONS', 'collections'),
            'collection'  => env('QURAN_EP_COLLECTION', 'collections/{slug}'),
            'categories_doa' => env('QURAN_EP_CATEGORIES_DOA', 'kategori-doa'),
            'content'     => env('QURAN_EP_CONTENT', 'contents/{slug}'),
            'wirid'       => env('QURAN_EP_WIRID', 'collections/{slug}'),
            'maulid'      => env('QURAN_EP_MAULID', 'collections/{slug}'),
            'doa'         => env('QURAN_EP_DOA', 'doa'),
        ],

        // Default query parameters sent with every request (e.g. category, source, language)
        'default_query' => [
            'category'    => env('QURAN_API_CATEGORY', null),
            'source'      => env('QURAN_API_SOURCE', 'kemenag'),
            'lang'        => env('QURAN_API_LANG', 'id'),
        ],

        // Custom HTTP Headers (Bearer tokens, API keys, Tenant ID, etc.)
        'headers' => [
            // 'X-Tenant-ID' => env('QURAN_TENANT_ID', null),
        ],

        'cache_ttl' => [
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
