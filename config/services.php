<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '690925494396768',
        'client_secret' => 'c6ae39d6daa459d65654ed4ff9a68a32',
        'redirect' => 'http://localhost/laramusic/public/callback/',
        ],

    'google' => [
        'client_id' => '847182856053-v7f0lc41lrldd5ja6rj3rr6o0tc22rot.apps.googleusercontent.com',
        'client_secret' => '4JsJzaR8bGFyObJKXpKgAMAs',
        'redirect' => 'http://localhost/laramusic/public/auth/google-callback',
        ],
];
