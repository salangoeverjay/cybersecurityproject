<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Password Pepper
    |--------------------------------------------------------------------------
    |
    | Pepper is a global secret that is NOT stored in the database.
    | Keep this long and random in .env (PASSWORD_PEPPER=...).
    |
    */
    'password_pepper' => env('PASSWORD_PEPPER'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Enforcement
    |--------------------------------------------------------------------------
    |
    | Force all requests to HTTPS in production deployments (e.g. Railway).
    | You can override with FORCE_HTTPS=true/false in environment variables.
    |
    */
    'force_https' => env('FORCE_HTTPS', env('APP_ENV', 'production') === 'production'),

    /*
    |--------------------------------------------------------------------------
    | HSTS (Strict-Transport-Security)
    |--------------------------------------------------------------------------
    |
    | Sent only on secure requests while HTTPS enforcement is enabled.
    |
    */
    'hsts_max_age' => (int) env('HSTS_MAX_AGE', 31536000),
    'hsts_include_subdomains' => env('HSTS_INCLUDE_SUBDOMAINS', true),
    'hsts_preload' => env('HSTS_PRELOAD', false),
];
