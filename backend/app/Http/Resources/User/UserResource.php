<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RolePermission\RoleResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'status' => $this->status,
            'avatar_url' => $this->avatar_url,
            'preivew' => $this->avatar_url ? url('/') . $this->avatar_url : '',
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'access_token' => $this->when($this->whenLoaded($this->access_token), $this->access_token),
        ];
    }
}
