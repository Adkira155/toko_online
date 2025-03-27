<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and configuration for Midtrans
    | payment gateway. Make sure to set these values in your .env file.
    |
    */

    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    'server_key' => env('MIDTRANS_SERVER_KEY'),

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    'sanitize' => true,

    'enable_3ds' => true,

    // URL untuk midtrans
    'payment_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];