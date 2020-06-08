<?php

namespace Ksd\Adminer\Http\Middleware\Validator;

use Closure;
use Validator;
use Response;

use App\Traits\ApiResponseHelper;

class CreateEmployee
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
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'displayName'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|max:20',
            'checkPassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->apiRespFail('E0002' , join(' ', $validator->errors()->all()));
        }

        return $next($request);
    }
}
