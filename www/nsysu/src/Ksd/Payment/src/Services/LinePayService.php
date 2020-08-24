<?php
/**
 * User: Lee
 * Date: 2017/11/07
 * Time: 下午2:20
 */

namespace Ksd\Payment\Services;

use Ksd\Payment\Repositories\LinePayRepository;

class LinePayService
{
	protected $repository;

	public function __construct(LinePayRepository $repository)
    {
    	$this->repository = $repository;
    }

    /**
     * reserve
     * @param $parameters
     * @return mixed
     */
    public function reserve($params = [])
    {
        return $this->repository->reserve($params);
    }

    /**
     * confirm
     * @param $parameters
     * @return mixed
     */
    public function confirm($parameters)
    {
        return $this->repository->confirm($parameters);
    }
}
