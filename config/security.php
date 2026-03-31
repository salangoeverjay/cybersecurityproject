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
];
