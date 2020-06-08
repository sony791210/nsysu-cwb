<?php

namespace Ksd\Adminer\Http\Middleware;

use App\Rules\Recaptcha;
use Ksd\Adminer\Services\EmployeeService;
use Closure;
use Log;
use Validator;
use Session;

class VerifyEmployeeSignin
{
    use \Ksd\Adminer\Traits\EmployeeValidator;

    protected $employeeServ;

    public function __construct(EmployeeService $employeeServ)
    {
        $this->employeeServ = $employeeServ;
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
        if ($this->isEmployeeValid()) {
            return $next($request);
        }

        $validator = Validator::make($request->all(), [
            'account'  => 'required',
            'password' => 'required',
//            'g-recaptcha-response' => [new Recaptcha],
        ]);
        if ($validator->fails()) {
            return redirect()->route('login')->withErrors(['帳號或密碼錯誤']);
        }

        $account = $request->input('account');
        $password = $request->input('password');
        if ($employee = $this->employeeServ->verify($account, $password)) {
            Session::put('employee', $employee);
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['帳號或密碼錯誤']);
    }
}
