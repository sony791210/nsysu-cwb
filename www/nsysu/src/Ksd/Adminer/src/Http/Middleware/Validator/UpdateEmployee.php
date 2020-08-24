<?php

namespace Ksd\Adminer\Http\Middleware\Validator;

use Closure;
use Validator;
use Response;

use App\Traits\ApiResponseHelper;

class UpdateEmployee
{
    use ApiResponseHelper;

    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $prop = [
            'displayName'     => 'required',
            'email'    => 'required|email'
        ];

        if ($request->has('password') && $request->input('password')) {
            $prop['password'] = 'required|min:6|max:20';
            $prop['checkPassword'] = 'required|same:password';
        }

        $validator = Validator::make($request->all(), $prop);

        if ($validator->fails()) {
            return $this->apiRespFail('E0002' , join(' ', $validator->errors()->all()));
        }

        return $next($request);
    }
}
