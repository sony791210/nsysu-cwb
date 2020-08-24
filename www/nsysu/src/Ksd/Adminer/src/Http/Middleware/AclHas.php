<?php

namespace Ksd\Adminer\Http\Middleware;

use Closure;
use Log;

class AclHas
{
    use \Ksd\Adminer\Traits\EmployeeValidator;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$acl)
    {
        $acl = array_map('trim', $acl);
        // 第一個參數為bool就判定為忽略view狀態
        if (isset($acl[0]) && preg_match("/^(TRUE|FALSE|true|false|1|0)$/", $acl[0])) {
            array_shift($acl);
            return $this->aclForceView(function () use ($request, $acl, $next) {
                if ($this->aclHas($acl)) {
                    return $next($request);
                }
                return abort(403, 'Unauthorized action');
            });
        }
        if ($this->aclHas($acl)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action');
    }
}
