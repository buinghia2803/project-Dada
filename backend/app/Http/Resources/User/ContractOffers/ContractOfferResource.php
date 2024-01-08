<?php

namespace App\Http\Resources\User\ContractOffers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Users\UserResource;

class ContractOfferResource extends JsonResource
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
            'email' => $this->email,
            'dad' => new UserResource($this->dad),
            'artist' => new UserResource($this->artist),
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'selling_price' => $this->selling_price,
            'dad_percent' => $this->dad_percent,
            'artist_percent' => $this->artist_percent,
            'dad_price' => $this->dad_price,
            'artist_price' => $this->artist_price,
            'system_price' => $this->system_price,
            'opensea_price' => $this->opensea_price,
            'system_percent' => $this->system_percent,
            'opensea_percent' => $this->opensea_percent,
            'responsibility' => $this->responsibility,
            'contact_info' => $this->contact_info,
            'contract_nft' => $this->contractNft,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
