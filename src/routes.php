<?php


$router->any(config('laravel-swagger.routes.docs').'/{jsonFile?}', [
    'as' => 'laravel-swagger.docs',
    'middleware' => config('laravel-swagger.routes.middleware.docs', []),
    'uses' => '\SaeedVaziry\LaravelSwagger\Http\Controllers\SwaggerController@docs',
]);

$router->get(config('laravel-swagger.routes.docs').'/asset/{asset}', [
    'as' => 'laravel-swagger.asset',
    'middleware' => config('laravel-swagger.routes.middleware.asset', []),
    'uses' => '\SaeedVaziry\LaravelSwagger\Http\Controllers\SwaggerAssetController@index',
]);