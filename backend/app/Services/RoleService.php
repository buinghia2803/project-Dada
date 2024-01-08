<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Log;

class RoleService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param UserRepository $userRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listRole($params)
    {
        return $this->list($params);
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    public function delete($role)
    {
        return $this->repository->delete($role);
    }

    /**
     * @param Role $role
     * @param array $permissions
     *
     * @return void
     */
    public function syncPermissions(Role $role, $permissions)
    {
        try {
            $role->syncPermissions($permissions);

            return true;
        } catch (\Exception $e) {
            Log::error('[RoleService->syncPermissions:' . __LINE__ . ']' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get permission of role.
     */
    public function getPermissions()
    {
        return $this->repository->getPermissions();
    }
}
