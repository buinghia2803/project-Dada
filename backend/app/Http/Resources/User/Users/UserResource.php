<?php

namespace App\Http\Resources\User\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'contract_address' => $this->contract_address,
                'created_at' => $this->created_at,
                'description' => $this->description,
                'email' => $this->email,
                'full_name' => $this->full_name,
                'id' => $this->id,
                'image_url' => $this->image_url,
                'positions' => $this->positions,
                'public_address_main' => $this->public_address_main,
                'public_address_sub' => $this->public_address_sub,
                'status' => $this->status,
                'type' => $this->type,
                'updated_at' => $this->updated_at,
            ];
    }
}
