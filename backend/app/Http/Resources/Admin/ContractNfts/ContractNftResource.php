<?php

namespace App\Http\Resources\Admin\ContractNfts;

use App\Http\Resources\Admin\ContractOffers\ContractOfferResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractNftResource extends JsonResource
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
            'contract_offer_id' => $this->contract_offer_id,
            'contractOffer' => new ContractOfferResource($this->contractOffer),
            'name' => $this->name,
            'image_url' => $this->image_url,
            'description' => $this->description,
            'token_url' => $this->token_url,
            'address_contract' => $this->address_contract,
            'token_contract' => $this->token_contract,
            'gas_fee' => $this->gas_fee,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
