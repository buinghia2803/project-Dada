<?php

namespace App\Http\Resources\User\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class DadInformationResource extends JsonResource
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
                'public_address_main' => $this->public_address_main,
                'public_address_sub' => $this->public_address_sub,
                'contract_address' => $this->contract_address,
                'email' => $this->email,
                'description' => $this->description,
                'full_name' => $this->full_name,
                'image_url' => $this->image_url ? url($this->image_url) : null,
                'positions' => $this->positions,
                'status' => $this->status,
                'type' => $this->type,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,
                'count_contract' => $this->count_contract,
            ];
    }
}
