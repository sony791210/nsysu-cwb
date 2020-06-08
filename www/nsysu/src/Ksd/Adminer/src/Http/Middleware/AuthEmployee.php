<?php

namespace Ksd\Adminer\Http\Middleware;

use Ksd\Adminer\Exceptions\EmployeeNotAuthorisedException;
use Closure;

class AuthEmployee
{
    use \Ksd\Adminer\Traits\EmployeeValidator;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isEmployeeValid()) {
            return $next($request);
        }
        else {
            return redirect()->route('login')->withErrors(['會員驗證已失效，請重新登入']);;
        }
        // throw new MemberNotAuthorisedException();
    }
}
