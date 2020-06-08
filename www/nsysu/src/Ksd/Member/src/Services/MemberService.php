<?php
/**
 * User: lee
 * Date: 2017/09/26
 * Time: 上午 9:42
 */

namespace Ksd\Member\Services;

use Ksd\Member\Repositories\MemberRepository;

class MemberService
{
    protected $repository;

    public function __construct(MemberRepository $repository)
    {
        $this->repository = $repository;
    }

     /**
     * 取得所有會員
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
    * 會員資料查詢
    * @param $data
    * @return mixed
    */
    public function query($data)
    {
        return $this->repository->query($data);
    }

    /**
     * 依據id,查詢使用者
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $member = $this->repository->find($id);

        if ($member) {
            // 移除不必要的欄位
            unset($member->password);
            unset($member->validPhoneCode);
            unset($member->validEmailCode);
        }

        return $member;
    }

    /**
     * 依據email,查詢使用者
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->repository->findByEmail($email);
    }
}
