<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\SettingUser;
use App\Repositories\SettingUserRepository;
use Illuminate\Support\Facades\Log;

class SettingUserService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param SettingUserRepository $settingUserRepository
     */
    public function __construct(SettingUserRepository $settingUserRepository)
    {
        $this->repository = $settingUserRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listSettingUser($params)
    {
        return $this->list($params);
    }

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function showSettingUser($params)
    {
        return $this->show($params, ['user']);
    }

    /**
     * @param SettingUser $settingUser
     *
     * @return void
     */
    public function delete($settingUser)
    {
        return $this->repository->delete($settingUser);
    }

    /**
     * Update setting.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function updateOrCreateSettingUser($request)
    {
        $condition = [
            'user_id' => $request->user_id,
        ];
        $data = [
            'contract_notify' => $request->contract_notify,
            'system_notify' => $request->system_notify,
            'updated_at' => now()
        ];

        return $this->updateOrCreate($condition, $data);
    }

    /**
     * GetByUserId
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getByUserId($user_id)
    {
        $setting = $this->repository->getByUserId($user_id);

        return $setting;
    }

    /**
     * GetByUserId
     *
     * @param  mixed $user_id
     * @return void
     */
    public function getNotificationByUser($user_id)
    {
        $setting = $this->repository->getNotificationByUser($user_id);

        return $setting;
    }
}
