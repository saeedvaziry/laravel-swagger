<?php

namespace Cotlet\LaravelSwagger;

use File;
use Cotlet\LaravelSwagger\Exceptions\LaravelSwaggerException;
use Symfony\Component\Yaml\Dumper as YamlDumper;

class Generator
{
    /**
     * @var string
     */
    protected $appDir;

    /**
     * @var string
     */
    protected $docDir;

    /**
     * @var string
     */
    protected $docsFile;

    /**
     * @var string
     */
    protected $yamlDocsFile;

    /**
     * @var array
     */
    protected $excludedDirs;

    /**
     * @var array
     */
    protected $constants;

    /**
     * @var \OpenApi\Annotations\OpenApi
     */
    protected $swagger;

    /**
     * @var bool
     */
    protected $yamlCopyRequired;

    public function __construct()
    {
        $this->appDir = config('laravel-swagger.paths.annotations');
        $this->docDir = config('laravel-swagger.paths.docs');
        $this->docsFile = $this->docDir.'/'.config('laravel-swagger.paths.docs_json', 'api-docs.json');
        $this->yamlDocsFile = $this->docDir.'/'.config('laravel-swagger.paths.docs_yaml', 'api-docs.yaml');
        $this->excludedDirs = config('laravel-swagger.paths.excludes');
        $this->constants = config('laravel-swagger.constants') ?: [];
        $this->yamlCopyRequired = config('laravel-swagger.generate_yaml_copy', false);
    }

    public static function generateDocs()
    {
        (new static)->prepareDirectory()
            ->defineConstants()
            ->scanFilesForDocumentation()
            ->populateServers()
            ->saveJson()
            ->makeYamlCopy();
    }

    /**
     * Check directory structure and permissions.
     *
     * @return Generator
     */
    protected function prepareDirectory()
    {
        if (File::exists($this->docDir) && ! is_writable($this->docDir)) {
            throw new LaravelSwaggerException('Documentation storage directory is not writable');
        }

        // delete all existing documentation
        if (File::exists($this->docDir)) {
            File::deleteDirectory($this->docDir);
        }

        File::makeDirectory($this->docDir);

        return $this;
    }

    /**
     * Define constant which will be replaced.
     *
     * @return Generator
     */
    protected function defineConstants()
    {
        if (! empty($this->constants)) {
            foreach ($this->constants as $key => $value) {
                defined($key) || define($key, $value);
            }
        }

        return $this;
    }

    /**
     * Scan directory and create Swagger.
     *
     * @return Generator
     */
    protected function scanFilesForDocumentation()
    {
        if ($this->isOpenApi()) {
            $this->swagger = \OpenApi\scan(
                $this->appDir,
                ['exclude' => $this->excludedDirs]
            );
        }

        if (! $this->isOpenApi()) {
            $this->swagger = \Swagger\scan(
                $this->appDir,
                ['exclude' => $this->excludedDirs]
            );
        }

        return $this;
    }

    /**
     * Generate servers section or basePath depending on Swagger version.
     *
     * @return Generator
     */
    protected function populateServers()
    {
        if (config('laravel-swagger.paths.base') !== null) {
            if ($this->isOpenApi()) {
                $this->swagger->servers = [
                    new \OpenApi\Annotations\Server(['url' => config('laravel-swagger.paths.base')]),
                ];
            }

            if (! $this->isOpenApi()) {
                $this->swagger->basePath = config('laravel-swagger.paths.base');
            }
        }

        return $this;
    }

    /**
     * Save documentation as json file.
     *
     * @return Generator
     */
    protected function saveJson()
    {
        $this->swagger->saveAs($this->docsFile);

        return $this;
    }

    /**
     * Save documentation as yaml file.
     *
     * @return Generator
     */
    protected function makeYamlCopy()
    {
        if ($this->yamlCopyRequired) {
            file_put_contents(
                $this->yamlDocsFile,
                (new YamlDumper(2))->dump(json_decode(file_get_contents($this->docsFile), true), 20)
            );
        }
    }

    /**
     * Check which documentation version is used.
     *
     * @return bool
     */
    protected function isOpenApi()
    {
        return version_compare(config('laravel-swagger.swagger_version'), '3.0', '>=');
    }
}
