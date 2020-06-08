<?php

namespace Ksd\Adminer\Services;


use Ksd\Adminer\Exceptions\EmployeeInsertException;
use Ksd\Adminer\Exceptions\EmployeeUpdateException;
use Ksd\Adminer\Events\EmployeeCreated;
use Ksd\Adminer\Events\EmployeeUpdated;
use Ksd\Adminer\Events\EmployeeRoleUpdated;
use Ksd\Adminer\Repositories\EmployeeRepository;
use App\Core\Hash;
use Log;
use DB;
use Config;
use Session;

class EmployeeService
{
    use \Ksd\Adminer\Traits\EmployeeManager;
    use \Ksd\Adminer\Traits\EmployeeValidator;


    protected $employeeRepo;


    private $employeeId = 0;

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo = $employeeRepo;

    }

    /**
     * 取得員工ID
     * @return int|null
     */
    public function getEmployeeId()
    {
        return Session::get('employee.employee_id');
    }

    /**
     * 取得員工資訊
     * @return int|null
     */
    public function getEmployee()
    {
        return Session::get('employee');
    }

    /**
     * 取得供應商ID
     * @return int|null
     */
    public function getSupplierId()
    {
        return Session::get('employee.supplier_id');
    }

    /**
     * 確認是否有權限
     * @param string $aclName
     * @return mixed
     */
    public function hasAcl($aclName)
    {
        return $this->hasOneAcl($aclName);
    }

    /**
     * Vender member is effect
     * @param string $account
     * @param string $password
     * @return mixed
     */
    public function verify($account, $password)
    {
        $member = null;
        $member = $this->employeeRepo->findByAccount($account);
        if(!$member)
            return false;
        if (Hash::check($password, $member->password)) {
            return $member;
        }
        return false;

    }


    /**
     * Add a membere's data
     * @param array $data
     * @param array|null $roles 角色表，如不做設定可不做填寫
     * @return Ksd\Member\Models\Member
     * @throws \Exception
     */
    public function add($data, $roles = null)
    {
        try {
            DB::beginTransaction();

            if ($this->employeeRepo->findByAccount($data['name'])) {
                throw new EmployeeInsertException('該帳戶已被使用');
            }
            $password = uniqid();
            $data = array_merge(['password' => $password], $data);
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $employee = $this->employeeRepo->add($data);
            if ($employee) {
                event(new EmployeeCreated($employee, $password));

                if ($roles && is_array($roles)) {
                    // 角色表不為空
                    $this->updateRole($employee->employee_id, $roles);
                }

                DB::commit();
                return $employee;
            }
            throw new EmployeeInsertException();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update data of memebr
     *
     * @param integer $memberId
     * @param array $data
     * @param array|null $roles 角色表，如不做更新可不做填寫
     * @return Ksd\Member\Models\Member
     */
    public function update($employeeId, $data, $roles = null)
    {

        try {
            $employee = $this->employeeRepo->find($employeeId);
            if (in_array($employee->account, Config::get('acl.protected_account')) && $this->getCurrentEmployee()->employee_id != $employeeId) {
                throw new EmployeeUpdateException('該帳戶為保護名單，資訊不可被修改');
            }

            DB::beginTransaction();
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            if ($employee = $this->employeeRepo->update($employeeId, $data)) {
                event(new EmployeeUpdated($employee));
                if ($roles && is_array($roles)) {
                    // 角色表不為空
                    $this->updateRole($employee->employee_id, $roles);
                    event(new EmployeeRoleUpdated($employee));
                }

                DB::commit();
                return $employee;
            }
            throw new EmployeeUpdateException();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update role's table list
     *
     * @param integer|object $member 可傳id或model物件
     * @param array $roleIds 角色id
     * @return Ksd\Member\Models\Member
     */
    public function updateRole($employeeId, $roleIds)
    {
        if (is_integer($employeeId)) {
            $employee = $this->find($employeeId);
            if (empty($employee)) {
                throw new EmployeeUpdateException('沒有此成員');
            }
        }
        $employee->role()->sync($roleIds);
        return $employee;
    }

    /**
     * 分頁取得所有成員
     *
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function listByPage($page = 1, $limit = 10)
    {
        return $this->employeeRepo->get()->slice(($page - 1) * $limit, $limit)->values()->all();
    }

    /**
     * get employee's data by employee's id
     *
     * @param integer $id
     * @return Ksd\Member\Models\Member
     */
    public function find($id)
    {
        return $this->employeeRepo->find($id);
    }

    /**
     * get employee's data by employee's account
     *
     * @param string $account
     * @return Ksd\Member\Models\Member
     */
    public function findByAccount($account)
    {
        return $this->employeeRepo->findByAccount($account);
    }

    /**
     * get name by id
     *
     * @param int $id
     * @return string
     */
    public function getName($id)
    {
        $employee = $this->find($id);

        return ($employee != null) ? $employee->name : '';
    }

    /**
     * get Token by id
     *
     * @param int $id
     * @return string
     */
    public function getToken($id)
    {
        return $this->employeeRepo->getToken($id);
    }

    /**
     * search
     *
     * @param array $params
     * @return App\Models\Backend\Employee
     */
    public function search($params)
    {
        return $this->employeeRepo->search($params);
    }

    public function updateToken($employee)
    {
        //舊登入方式需求
        // 重置employee_token
        $employee_token = hash('sha256', time() . $employee->employee_username);
        //重置token效期
        $expire_at = date('Y-m-d H:i:s', strtotime('+12 hours'));

        //新登入方式
        // 取access_token
        $access_token = $this->jwtTokenService->generateToken($employee->employee_id);

        // 更新
        $member = $this->update($employee->employee_id, ['employee_token' => $employee_token, 'expire_at' => $expire_at, 'access_token' => $access_token]);

        if (!$member) return null;

        return $member;
    }
}
