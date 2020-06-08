<?php
/**
 * User: Lee
 * Date: 2019/06/25
 * Time: 下午2:20
 */

namespace Ksd\Payment\Services;

use Ksd\Payment\Repositories\CathayRepository;

class CathayService
{
	protected $repository;

	public function __construct(CathayRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 自動扣款建立訂單
     * @param $order
     * @return mixed
     */
    public function createPeriodOrder($params)
    {
        return $this->repository->createPeriodOrder($params);
    }

    /**
     * 自動扣款
     * @param $params
     * @return mixed
     */
    public function preapprovedPay($params)
    {
        return $this->repository->preapprovedPay($params);
    }
}
