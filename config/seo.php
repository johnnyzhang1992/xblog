<?php

return array(


    /*
	|--------------------------------------------------------------------------
	| site name
	|--------------------------------------------------------------------------
    |
    |
    */
//    'default_site_name' => env('SEO_DEFAULT_SITE_NAME'),
//    'default_admin_site_name' => env('SEO_DEFAULT_ADMIN_SITE_NAME'),

    /*
	|--------------------------------------------------------------------------
	| defautl meta data
	|--------------------------------------------------------------------------
    |
    |
    */
//    'default_keywords' => env('SEO_DEFAULT_KEYWORDS', ''),
//    'default_description' => env('SEO_DEFAULT_DESCRIPTION', ''),

    /* not tracking ip */
    'exclude' => [
        'ip' => [
            '67.85.30.134',
            '59.125.182.207',
            '69.249.38.235',
            '113.97.7.218',
        ],
        'name' => [
            'johnnyzhang'
        ]
    ],

    'default_sub_title' => '',
    'poi_sub_title' => '',

    /* static page titles */
    'static_page_titles' => [

    ],
);
