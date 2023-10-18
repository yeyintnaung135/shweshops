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
        //
        'catfilter',
        'get_items_cat_ajax/*',
        'backside/shop_owner/items',
        'backside/shop_owner/editajax',
        'webhook',
        'search_by_type','ajax_search_result','checkvalidate'

    ];
}
