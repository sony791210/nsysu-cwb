<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Module\Employee\EmployeeService;
use Ksd\Adminer\Services\RoleService;
use Ksd\Adminer\Services\EmployeeService as EmployeeServ;
use Validator;
use Hashids\Hashids;

class EmployeeController extends BaseController
{
    protected $service;
    protected $roleService;
    protected $employeeServ;

    public function __construct(EmployeeService $service, RoleService $roleService, EmployeeServ $employeeServ)
    {
        $this->service = $service;
        $this->roleService = $roleService;
        $this->employeeServ = $employeeServ;
    }

    /**
     * 列表
     * @return
     */
    public function index()
    {
        $data['fields'] = collect([
            ['prop' => 'name', 'label' => trans('admin/employee.name')],
            ['prop' => 'displayName', 'label' => trans('admin/employee.displayName')],
            ['prop' => 'email', 'label' => trans('admin/employee.email')],
            ['prop' => 'status', 'label' => trans('admin/employee.status')],
        ])->toJson();

        $data['list'] = $this->service->all()->map(function ($row) {
            return [
                'id' => $row->employee_id,
                'name' => $row->name,
                'displayName' => $row->displayName,
                'email' => $row->email,
                'status' => $row->status == 1 ? '啟用' : '停用',
                'editUrl' => route('employee.edit', $row->employee_id)
            ];
        })->toJson();

        return view('admin.employee.index', $data);
    }

    public function edit(Request $request, $id)
    {
        if (!$id)
            return redirect()->route('employee.index');

        $employee = $this->employeeServ->find($id);
        $data['employee'] = $employee->toJson();

        $data['role'] = $this->roleService->getAvailable()->map(function ($row) {
            return [
                'key' => $row->id,
                'label' => $row->name . '(' . $row->description . ')'
            ];
        })->toJson();
        $data['hasRole'] = collect($employee->getRawRole()->all())->toJson();
        return view('admin.employee.edit', $data);
    }

    /**
     * 新增頁面
     * @return
     */
    public function new()
    {
        $data['role'] = $this->roleService->getAvailable(1, PHP_INT_MAX)->map(function ($row) {
            return [
                'key' => $row->id,
                'label' => $row->name . '(' . $row->description . ')'
            ];
        })->toJson();

        return view('admin.employee.new', $data);
    }

    /**
     * 新增
     * @return
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'displayName' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
            'checkPassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->apiRespFailCode('E0002', join(' ', $validator->errors()->all()));
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'displayName' => $request->input('displayName'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'status' => $request->input('status', false)
            ];
            //todo transaction

            $result = $this->employeeServ->add($data, $request->input('role', null));
            $hashids = new Hashids('crm', 10);
            $code = $hashids->encode($result->employee_id);
            $updateData = [
                'personal_code' => $code
            ];
            $this->employeeServ->update($result->employee_id, $updateData, $request->input('role', null));
            return $this->apiRespSuccess();
        } catch (\Exception $e) {
            dd($e);
            \Log::debug(print_r($e->getMessage(), true));
            return $this->apiRespFail('E0002', $e->getMessage());
        }
    }

    /**
     * 編輯
     * @return
     */
    public function update(Request $request, $id)
    {
        try {
            $prop = [
                'displayName' => $request->input('displayName'),
                'email' => $request->input('email'),
                'status' => $request->input('status', false),
            ];

            if ($request->has('password') && $request->input('password')) {
                $prop['password'] = $request->input('password');
            }


            $result = $this->employeeServ->update($id, $prop, $request->input('role', []));

            return ($result) ? $this->apiRespSuccess() : $this->apiRespFailCode('E0003');
        } catch (\Exception $e) {
            return $this->apiRespFail('E0003', $e->getMessage());
        }
    }
}