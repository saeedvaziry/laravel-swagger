<?php

return [
    'api' => [
        /*
        |--------------------------------------------------------------------------
        | Edit to set the api's title
        |--------------------------------------------------------------------------
        */

        'title' => 'Laravel Swagger UI',
    ],

    'routes' => [
        /*
        |--------------------------------------------------------------------------
        | Route for accessing parsed swagger annotations.
        |--------------------------------------------------------------------------
        */

        'docs' => 'docs',

        /*
        |--------------------------------------------------------------------------
        | Middleware allows to prevent unexpected access to API documentation
        |--------------------------------------------------------------------------
         */
        'middleware' => [
            'api' => [],
            'asset' => [],
            'docs' => [],
            'oauth2_callback' => [],
        ],
    ],

    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Absolute path to location where parsed swagger annotations will be stored
        |--------------------------------------------------------------------------
        */

        'docs' => storage_path('api-docs'),

        /*
        |--------------------------------------------------------------------------
        | File name of the generated json documentation file
        |--------------------------------------------------------------------------
        */

        'docs_json' => 'api-docs.json',

        /*
        |--------------------------------------------------------------------------
        | File name of the generated YAML documentation file
        |--------------------------------------------------------------------------
         */

        'docs_yaml' => 'api-docs.yaml',

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directory containing the swagger annotations are stored.
        |--------------------------------------------------------------------------
        */

        'annotations' => base_path('app'),

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directory where to export views
        |--------------------------------------------------------------------------
        */

        'views' => base_path('resources/views/vendor/laravel-swagger'),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the api's base path
        |--------------------------------------------------------------------------
        */

        'base' => env('LARAVEL_SWAGGER_BASE_PATH', null),

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directories that you would like to exclude from swagger generation
        |--------------------------------------------------------------------------
        */

        'excludes' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Turn this on to generate a copy of documentation in yaml format
    |--------------------------------------------------------------------------
     */

    'generate_yaml_copy' => env('LARAVEL_SWAGGER_GENERATE_YAML_COPY', false),

    /*
    |--------------------------------------------------------------------------
    | Edit to set the swagger version number
    |--------------------------------------------------------------------------
    */

    'swagger_version' => env('SWAGGER_VERSION', '2.0'),

    /*
    |--------------------------------------------------------------------------
    | Uncomment to add constants which can be used in anotations
    |--------------------------------------------------------------------------
     */
    'constants' => [
        'LARAVEL_SWAGGER_CONST_HOST' => env('LARAVEL_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
    ],
];
