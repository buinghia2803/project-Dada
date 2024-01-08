<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\PermissionRepository;

class PermissionService extends BaseService
{

    /**
     * PermissionService construct
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }
}
