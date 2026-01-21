<?php

return [
    'store_id'       => env('SSLCOMMERZ_STORE_ID'),
    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),
    'sandbox'        => env('SSLCOMMERZ_SANDBOX', true),

    'success_url' => env('SSLCOMMERZ_SUCCESS_URL'),
    'fail_url'    => env('SSLCOMMERZ_FAIL_URL'),
    'cancel_url'  => env('SSLCOMMERZ_CANCEL_URL'),
];
