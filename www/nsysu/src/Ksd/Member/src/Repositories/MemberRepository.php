<?php
/**
 * User: lee
 * Date: 2017/09/26
 * Time: 上午 9:42
 */

namespace Ksd\Member\Repositories;

use Illuminate\Database\QueryException;

use Ksd\Member\Models\Member;
use Log;

class MemberRepository
{
    protected $model;

    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    /**
     * 找所有會員
     * @param $data
     * @return mixed
     */
     public function query($data)
     {
        $query = $this->model->where($data);
        // 如果搜尋email也要連同第三方帳號一起搜尋
        if (isset($data['email'])) {
            $members = $query->orWhere('openId', $data['email'])->get();
        }
        else {
            $members = $query->get();
        }

        // 將第三方登入openId對到email
        if ($members) {
            foreach ($members as $key => $member) {
                if ($member['openPlateform'] != 'citypass') $members[$key]['email'] = $member['openId'];
            }
        }

        return $members;
     }

     /**
     * 找所有會員
     * @param $email
     * @return mixed
     */
     public function all()
     {
         $members = $this->model->all();

         // 將第三方登入openId對到email
         if ($members) {
            foreach ($members as $key => $member) {
                if ($member['openPlateform'] != 'citypass') $members[$key]['email'] = $member['openId'];
            }
         }

         return $members;
     }

    /**
     * 依據帳號,查詢使用者認証
     * @param $email
     * @return mixed
     */
    public function find($id)
    {
        $member = $this->model->find($id);

        return $this->memberEmailMapping($member);
    }

    /**
     * 依據帳號,查詢使用者
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        $member = $this->model->whereEmail($email)->first();

        if (!$member) {
            $member = $this->model->where('openId', $email)->first();
        }

        return $member;
    }

    /**
     * 對應第三方登入使用者的Email
     * @param $member
     * @return mixed
     */
    private function memberEmailMapping($member)
    {
        if ($member && $member->openPlateform != 'citypass') {
            $member->email = $member->openId;
        }

        return $member;
    }
}
