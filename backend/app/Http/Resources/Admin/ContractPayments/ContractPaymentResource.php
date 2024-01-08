<?php

namespace App\Http\Resources\Admin\ContractPayments;

use App\Http\Resources\Admin\ContractNfts\ContractNftResource;
use App\Http\Resources\Admin\ContractOffers\ContractOfferResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractPaymentResource extends JsonResource
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
                'contract_nft_id' => $this->contract_nft_id,
                'contract_offer_id' => $this->contract_offer_id,
                'contractOffer' => new ContractOfferResource($this->whenLoaded('contractOffer')),
                'contractNft' => new ContractNftResource($this->whenLoaded('contractNft')),
                'dad_price' => $this->dad_price,
                'artist_price' => $this->artist_price,
                'status' => $this->status,
            ];
    }
}
