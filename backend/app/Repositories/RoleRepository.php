<?php

namespace App\Repositories;

use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $Role
     * @return RoleRepository
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param mixed $query
     * @param mixed $column
     * @param mixed $data
     *
     * @return Query
     */
    public function mergeQuery($query, $column, $data)
    {
        switch ($column) {
            case 'name':
                return $query->where($column, 'like', '%' . $data . '%');
            case 'raw':
                return $query->whereRaw($data);
            case 'raw':
                return $query->whereRaw($data);
            default:
                return $query;
        }
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    public function delete($role)
    {
        DB::table('model_has_roles')->where('role_id', $role->id)->delete();
        $role->syncPermissions();
        $role->delete();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * @param Role $role
     * @param array $permissions
     *
     * @return void
     */
    public function syncPermissions(Role $role, $permissions)
    {
        $oldNames = $role->permissions()->pluck('name')->toArray();
        $role->syncPermissions($permissions);
    }

    /**
     * Get permission list.
     *
     * @return Permission
     */
    public function getPermissions()
    {
        return Permission::get();
    }
}
