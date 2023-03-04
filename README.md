# Laravel Database Ask:
Interact with your database using natural language

Ask DB allows you to use OpenAI's GPT-3 to build natural language database queries.

```php
$dbAsk = new DatabaseAsk();
$dbAsk->prompt('How many users do we have on the "pro" plan?');
```

## Installation

You can install the package via composer.
By default, Composer pulls in packages from Packagist, so you’ll have to make a slight adjustment to your new project composer.json file. Open the file and update include the following array somewhere in the object:

```bash
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/masrimohammad/laravel-database-ask"
    }
]
```

```bash
composer require database/ask
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="database-ask"
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
DATABASE_ASK_CONNECTION=mysql
DATABASE_ASK_STRICT_MODE=true
```

Then, you can use the `DatabaseAsk::prompt()` method to ask the database:

```php
$dbAsk = new DatabaseAsk();
$dbAsk->prompt('How many users do we have on the "pro" plan?');
```

## Credits

- https://github.com/beyondcode/laravel-ask-database

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
