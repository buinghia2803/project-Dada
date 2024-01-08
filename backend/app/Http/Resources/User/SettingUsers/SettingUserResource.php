<?php

namespace App\Http\Resources\User\SettingUsers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Users\UserResource;

class SettingUserResource extends JsonResource
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
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'user' => new UserResource($this->whenLoaded('user')),
                'contract_notify' => $this->contract_notify,
                'system_notify' => $this->system_notify,
                'user_id' => $this->user_id,
            ];
    }
}
