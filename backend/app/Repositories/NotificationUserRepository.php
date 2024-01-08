<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\BaseRepository;
use App\Models\NotificationUser;

class NotificationUserRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $notificationuser
     * @return NotificationUserRepository
     */
    public function __construct(NotificationUser $notificationUser)
    {
        $this->model = $notificationUser;
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
        $authType = auth()->guard('user_api')->user()->type;
        switch ($column) {
            case 'id':
            case 'notification_id':
            case 'admin_id':
            case 'user_from':
            case 'user_to':
            case 'status':
            case 'created_at':
            case 'updated_at':
                $query->where($column, $data);
                break;
            case 'activeKey':
                if ($data == 'notify_sys') {
                    switch ($authType) {
                        case NotificationUser::ROLE_DAD:
                            return $query->whereHas('notification', function ($q) {
                                return $q->where('sender_type', NotificationUser::SENDER_TYPE_ADMIN_SEND)
                                    ->where(function ($queryType) {
                                        return $queryType->where('type', NotificationUser::TYPE_SEND_ALL_SYSTEM)
                                            ->orWhere('type', NotificationUser::TYPE_SEND_ALL_DAD);
                                    });
                            });
                        case NotificationUser::ROLE_ARTIST:
                            return $query->whereHas('notification', function ($q) {
                                return $q->where('sender_type', NotificationUser::SENDER_TYPE_ADMIN_SEND)
                                    ->where(function ($queryType) {
                                        return $queryType->where('type', NotificationUser::TYPE_SEND_ALL_SYSTEM)
                                            ->orWhere('type', NotificationUser::TYPE_SEND_ALL_ARTIST);
                                    });
                            });
                    }
                } else {
                    switch ($authType) {
                        case NotificationUser::ROLE_DAD:
                            return $query->whereHas('notification', function ($q) {
                                return $q->where('sender_type', NotificationUser::SENDER_TYPE_ARTIST_SEND)
                                    ->where('type', NotificationUser::TYPE_SEND_ALL_DAD);
                            })->where('user_to', $authType = auth()->guard('user_api')->user()->id);

                        case NotificationUser::ROLE_ARTIST:
                            return $query->whereHas('notification', function ($q) {
                                return $q->where('sender_type', NotificationUser::SENDER_TYPE_DAD_SEND)
                                    ->where('type', NotificationUser::TYPE_SEND_ALL_ARTIST);
                            })->where('user_to', $authType = auth()->guard('user_api')->user()->id);
                        default:
                    }
                }
                return $query->where($column, $data);
            default:
                return $query;
        }
    }

    public function updateStatusNotify($params)
    {
        $this->model::whereIn('id', $params)->update([
            'status' => 1,
        ]);
    }
}
