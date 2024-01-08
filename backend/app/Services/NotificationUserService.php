<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\NotificationUser;
use App\Repositories\NotificationUserRepository;
use Illuminate\Support\Facades\Log;

class NotificationUserService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param NotificationUserRepository $notificationUserRepository
     */
    public function __construct(NotificationUserRepository $notificationUserRepository)
    {
        $this->repository = $notificationUserRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listNotificationUser($params)
    {
        return $this->list($params, ['notification', 'admin', 'userForm', 'userTo']);
    }

    /**
     * @param NotificationUser $notificationUser
     *
     * @return void
     */
    public function delete($notificationUser)
    {
        return $this->repository->delete($notificationUser);
    }

    /**
     * @param NotificationUser $notificationUser
     *
     * @return void
     */
    public function updateStatusNotify($params)
    {
        return $this->repository->updateStatusNotify($params);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function merge_params($request, $watched)
    {
        $dataCondition = [
            'status' => $watched,
        ];

        $request->merge($dataCondition);

        return $params = $request->only('status');
    }
}
