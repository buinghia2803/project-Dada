<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\RevenueRepository;
use Illuminate\Support\Facades\DB;

class RevenueService extends BaseService
{
    const STATUS = [
        'SOLD' => 3,
    ];

    /**
     * Initializing the instances and variables
     *
     * @param RevenueRepository $revenueRepository
     */
    public function __construct(RevenueRepository $revenueRepository)
    {
        $this->repository = $revenueRepository;
    }

    /**
     * SumDataRevenue
     *
     * @param  mixed $params
     * @return void
     */
    public function sumDataRevenue($params)
    {
        $params['status'] = self::STATUS['SOLD'];

        return $this->repository->sumData($params);
    }

    /**
     * SumListDataUserRevenue
     *
     * @param  mixed $params
     * @return void
     */
    public function sumListDataUserRevenue($params)
    {
        $params['status'] = self::STATUS['SOLD'];

        return $this->repository->countDataUser($params);
    }
}
