<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Log;

class NotificationService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->repository = $notificationRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listNotification($params)
    {
        return $this->list($params);
    }

    /**
     * @param Notification $notification
     *
     * @return void
     */
    public function delete($notification)
    {
        return $this->repository->delete($notification);
    }
}
