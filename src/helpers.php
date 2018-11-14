<?php

use SaeedVaziry\LaravelSwagger\Exceptions\LaravelSwaggerException;

if (! function_exists('swagger_ui_dist_path')) {
    /**
     * Returns swagger-ui composer dist path.
     *
     * @param null $asset
     *
     * @return string
     * @throws \SaeedVaziry\LaravelSwagger\Exceptions\LaravelSwaggerException
     */
    function swagger_ui_dist_path($asset = null)
    {
        $allowed_files = [
            'favicon-16x16.png',
            'favicon-32x32.png',
            'oauth2-redirect.html',
            'swagger-ui-bundle.js',
            'swagger-ui-bundle.js.map',
            'swagger-ui-standalone-preset.js',
            'swagger-ui-standalone-preset.js.map',
            'swagger-ui.css',
            'swagger-ui.css.map',
            'swagger-ui.js',
            'swagger-ui.js.map',
        ];

        $path = base_path('vendor/swagger-api/swagger-ui/dist/');

        if (! $asset) {
            return realpath($path);
        }

        if (! in_array($asset, $allowed_files)) {
            throw new LaravelSwaggerException(sprintf('(%s) - this Laravel Swagger asset is not allowed', $asset));
        }

        return realpath($path.$asset);
    }
}

if (! function_exists('laravel_swagger_asset')) {
    /**
     * Returns asset from swagger-ui composer package.
     *
     * @param $asset string
     *
     * @return string
     * @throws \LaravelSwagger\Exceptions\LaravelSwaggerException
     */
    function laravel_swagger_asset($asset)
    {
        $file = swagger_ui_dist_path($asset);

        if (! file_exists($file)) {
            throw new LaravelSwaggerException(sprintf('Requested Laravel Swagger asset file (%s) does not exists', $asset));
        }

        return route('laravel-swagger.asset', $asset).'?v='.md5_file($file);
    }
}
