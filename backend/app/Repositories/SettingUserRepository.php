<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\BaseRepository;
use App\Models\SettingUser;

class SettingUserRepository extends BaseRepository
{
    /**
     * Initializing the instances and variables
     *
     * @param Model $settinguser
     * @return SettingUserRepository
     */
    public function __construct(SettingUser $settingUser)
    {
        $this->model = $settingUser;
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
            case 'created_at':
                return $query->where($column, $data);
            case 'updated_at':
                return $query->where($column, $data);
            case 'user_id':
                return $query->where($column, $data);
            case 'contract_notify':
                return $query->where($column, $data);
            case 'system_notify':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }

    /**
     * GetByUserId
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getByUserId($user_id)
    {
        $setting = $this->model->where('user_id', $user_id)->first();

        return $setting;
    }

    /**
     * GetNotificationByUser
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getNotificationByUser($user_id)
    {
        $setting = $this->model->where('user_id', $user_id)->first();
        $authType = auth()->guard('user_api')->user()->type;
        $data = [];
        if (!$setting || ($setting->contract_notify == 0 && $setting->system_notify == 0)) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
            switch ($authType) {
                case SettingUser::ROLE_DAD:
                    $notification = Notification::where([
                        'status' => SettingUser::STATUS_SENT,
                        'sender_type' => SettingUser::SENDER_TYPE_ADMIN_SEND && SettingUser::SENDER_TYPE_ARTIST_SEND,
                    ])
                        ->whereIn('type', [
                            SettingUser::TYPE_SEND_ALL_DAD,
                            SettingUser::TYPE_SEND_ALL_SYSTEM,
                        ])
                        ->count();
                    break;
                case SettingUser::ROLE_ARTIST:
                    $notification = Notification::where([
                        'status' => SettingUser::STATUS_SENT,
                        'sender_type' => SettingUser::SENDER_TYPE_ADMIN_SEND && SettingUser::SENDER_TYPE_DAD_SEND,
                    ])
                        ->whereIn('type', [
                            SettingUser::TYPE_SEND_ALL_ARTIST,
                            SettingUser::TYPE_SEND_ALL_SYSTEM,
                        ])
                        ->count();
                    break;
            };
            $data['noti'] = $notification;
        }
        return $data;
    }
}
