<?php

// SSLCommerz configuration

$apiDomain = "https://sandbox.sslcommerz.com";
return [
    'apiCredentials' => [
        'store_id' => 'ultim63ba93189af86',           // Replace with your store id
        'store_password' => 'ultim63ba93189af86@ssl', // Replace with your password
    ],

    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],

    'apiDomain' => $apiDomain,
    'connect_from_localhost' => true, // true for local sandbox, false for live

    // Full URLs are better in production, for local testing relative URLs are okay
    'success_url' => '/payment/ssl/success',
    'failed_url' => '/payment/ssl/fail',
    'cancel_url' => '/payment/ssl/cancel',
    'ipn_url' => '/payment/ssl/ipn',
];