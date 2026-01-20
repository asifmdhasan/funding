<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',  // Exclude all API routes from CSRF protection
        'payment/ssl/success-ipn',
    'payment/ssl/fail-ipn',
    'payment/ssl/cancel-ipn',
    ];
}