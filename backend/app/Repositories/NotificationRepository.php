<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $notification
     * @return NotificationRepository
     */
    public function __construct(Notification $notification)
    {
        $this->model = $notification;
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
            case 'id':
                return $query->where($column, $data);
            case 'title':
                return $query->where($column, $data);
            case 'content':
                return $query->where($column, $data);
            case 'action':
                return $query->where($column, $data);
            case 'type':
                return $query->where($column, $data);
            case 'date_public':
                if (isset($data)) {
                    if (isset($data[0]) && $data[0]) {
                        $query = $query->where($column, '>=', Carbon::parse($data[0])->format('Y-m-d'));
                    }
                    if (isset($data[1]) && $data[1]) {
                        $query = $query->where($column, '<=', Carbon::parse($data[1])->format('Y-m-d'));
                    }
                }
                return $query;
            case 'status':
                return $query->where($column, $data);
            case 'created_at':
                return $query->where($column, $data);
            case 'updated_at':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }
}
