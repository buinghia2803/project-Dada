<?php

namespace App\Http\Resources\User\NotificationUsers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Notifications\NotificationResource;
use App\Http\Resources\Admin\Users\AdminResource;
use App\Http\Resources\Admin\Users\UserResource;

class NotificationUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'notification' => new NotificationResource($this->notification),
                'admin' => new AdminResource($this->admin),
                'user_from' => new UserResource($this->userForm),
                'user_to' => new UserResource($this->userTo),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
