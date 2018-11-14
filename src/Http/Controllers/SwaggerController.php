<?php

namespace SaeedVaziry\LaravelSwagger\Http\Controllers;

use File;
use Response;
use Illuminate\Routing\Controller as BaseController;

class SwaggerController extends BaseController
{
    /**
     * Dump api-docs.json content endpoint.
     *
     * @param string $jsonFile
     *
     * @return \Response
     */
    public function docs($jsonFile = null)
    {
        $filePath = config('laravel-swagger.paths.docs').'/'.
            (!is_null($jsonFile) ? $jsonFile : config('laravel-swagger.paths.docs_json', 'api-docs.json'));

        if (!File::exists($filePath)) {
            abort(404, 'Cannot find '.$filePath.' and cannot be generated.');
        }

        $content = File::get($filePath);

        return Response::make($content, 200, [
            'Content-Type' => 'application/json',
        ]);
    }
}
