<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Waxum API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your Waxum WhatsApp API server instance.
    | Example: http://localhost:3451
    |
    */
    'base_url' => env('WAXUM_BASE_URL', 'http://localhost:3451'),

    /*
    |--------------------------------------------------------------------------
    | Waxum API Token
    |--------------------------------------------------------------------------
    |
    | The Bearer authentication token for your Waxum API user session.
    | This can be overridden per-request when using the client directly.
    |
    */
    'token' => env('WAXUM_TOKEN'),
];
