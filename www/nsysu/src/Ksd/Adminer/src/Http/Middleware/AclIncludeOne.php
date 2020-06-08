<?php

namespace Ksd\Adminer\Http\Middleware;

use Closure;

class AclIncludeOne
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
        if ($this->aclIncludeOne($acl)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action');
    }
}
