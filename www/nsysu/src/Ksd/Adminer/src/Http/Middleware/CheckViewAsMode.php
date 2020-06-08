<?php

namespace Ksd\Adminer\Http\Middleware;

use Closure;
use Log;

class CheckViewAsMode
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
        if ($request->isMethod('post') and $this->inViewAsMode()) {
            return back()->withErrors(['檢視角度模式下不能進行資料新增或更新']);
        }
        return $next($request);
    }
}
