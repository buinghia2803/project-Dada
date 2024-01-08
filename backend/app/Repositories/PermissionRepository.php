<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $user
     * @return PermissionRepository
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * Search
     *
     * @param  mixed $query  Query.
     * @param  mixed $column Column.
     * @param  mixed $data   Data.
     *
     * @return mixed
     */
    public function mergeQuery($query, $column, $data)
    {
        switch ($column) {
            case 'name':
                return $query->where($column, 'like', '%' . $data . '%');
            case 'is_deleted':
            case 'type':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }
}
