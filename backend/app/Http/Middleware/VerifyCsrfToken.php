<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // exclude from localhost due to bug with request-docs package
        // request-docs package bundles the api calls with origin and referer
        // which seem to trigger CSRF token mismatch
        'http://localhost/*'
    ];
}
