<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'wxxcx/*'
    ];
    public function handle($request, Closure $next)
    {
        // 如果是来自 api 域名，就跳过检查
        if ($_SERVER['SERVER_NAME'] != 'servicewechat.com')
        {
            return parent::handle($request, $next);
        }else{
            return $next($request);
        }
    }
}
