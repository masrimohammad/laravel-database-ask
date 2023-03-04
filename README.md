# Laravel Database Ask:
Interact with your database using natural language

Ask DB allows you to use OpenAI's GPT-3 to build natural language database queries.

```php
DataBaseAsk::prompt('How many users do we have on the "pro" plan?');
```

## Installation

You can install the package via composer:

```bash
composer require masrimohamad/laravel-database-ask
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="database-ask-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * Package name
     */
    'name' => 'Database Ask',

    /**
     * Open AI api key
     */
    'open_ai_api_key' => env('DATABASE_ASK_OPEN_AI_API_KEY'),

    /**
     * Database connection type
     */
    'connection' => env('DATABASE_ASK_CONNECTION'),

    /**
     * Strict mode will throw an exception when the query
     * would perform a write/alter operation on the database.
     *
     * If you want to allow write operations - or if you are using a read-only
     * database user - you may disable strict mode.
     */
    'strict_mode' => env('DATABASE_ASK_STRICT_MODE'),
];
```

## Usage

First, you need to configure your OpenAI API key in your `.env` file:

```dotenv
DATABASE_ASK_OPEN_AI_API_KEY=sk-...
```

Then, you can use the `DatabaseAsk::prompt()` method to ask the database:

```php
$response = DB::ask('How many users are there?');
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- https://github.com/beyondcode/laravel-ask-database

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
