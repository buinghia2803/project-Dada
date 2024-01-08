<?php

namespace App\Http\Resources\User\Tokens;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
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
                'id_artist' => $this->id_artist,
                'token_contract_offer' => $this->token_contract_offer,
                'token_confirm' => $this->token_confirm,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}