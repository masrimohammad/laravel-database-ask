<?php

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
