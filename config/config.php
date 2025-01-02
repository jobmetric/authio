<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Time
    |--------------------------------------------------------------------------
    |
    | Cache time for get data authio
    |
    | - set zero for remove cache
    | - set null for forever
    |
    | - unit: minutes
    */

    "cache_time" => env("AUTHIO_CACHE_TIME", 0),

    /*
    |--------------------------------------------------------------------------
    | Table Name
    |--------------------------------------------------------------------------
    |
    | Table name in database
    */

    "tables" => [
        'user' => 'users',
        'user_otp' => 'user_otps',
        'user_token' => 'user_tokens',
    ],

    /*
    |--------------------------------------------------------------------------
    | Background Image
    |--------------------------------------------------------------------------
    |
    | Background image for authio
    */

    "background_image" => env("AUTHIO_BACKGROUND_IMAGE", "bg7"),

];
