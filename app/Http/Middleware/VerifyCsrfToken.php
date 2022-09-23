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
        // add here when csrf token mismatch
        "/admin/check-current-pw","/admin/update-category-status","/admin/update-product-status","/admin/update-attribute-status"
    ];
}
