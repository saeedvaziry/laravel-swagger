# Laravel Swagger

Laravel Swagger UI Generator

## Installation

`composer require saeedvaziry/laravel-swagger`

Make sure you have this packages in your `composer.json` :

    "swagger-api/swagger-ui": "^3.19",
    "zircote/swagger-php": "~2.0"

## Usage

`php artisan laravel-swagger:generate --source=app/Http/Controllers --output=api-docs`

This will generate `api-docs.json` in `storage/api-docs` folder

## License

The Laravel Swagger is open-sourced software licensed under the MIT license.
