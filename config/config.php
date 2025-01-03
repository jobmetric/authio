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

    /*
    |--------------------------------------------------------------------------
    | Enable Send SMS
    |--------------------------------------------------------------------------
    |
    | Enable send sms for authio
    */

    "enable_send_sms" => env("AUTHIO_ENABLE_SEND_SMS", true),

    /*
    |--------------------------------------------------------------------------
    | Enable Send Email
    |--------------------------------------------------------------------------
    |
    | Enable send email for authio
    */

    "enable_send_email" => env("AUTHIO_ENABLE_SEND_EMAIL", true),

    /*
    |--------------------------------------------------------------------------
    | Otp Code
    |--------------------------------------------------------------------------
    |
    | Otp code for authio
    */

    'otp' => [
        'default_value' => env('AUTHIO_OTP_DEFAULT_VALUE', 12345),
        'try_count' => env('AUTHIO_OTP_TRY_COUNT', 5),
        'expire_reuse' => env('AUTHIO_OTP_EXPIRE_REUSE', 60),
        'expire_time' => env('AUTHIO_OTP_EXPIRE_TIME', 300),
        'ban_ip' => env('AUTHIO_OTP_BAN_IP', 600),
    ],

];
