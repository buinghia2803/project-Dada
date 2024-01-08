<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $setting
     * @return SettingRepository
     */
    public function __construct(Setting $setting)
    {
        $this->model = $setting;
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
            case 'created_at':
                return $query->where($column, $data);
            case 'currency_eth':
                return $query->where($column, $data);
            case 'id':
                return $query->where($column, $data);
            case 'opensea_percent':
                return $query->where($column, $data);
            case 'system_percent':
                return $query->where($column, $data);
            case 'updated_at':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }
}
