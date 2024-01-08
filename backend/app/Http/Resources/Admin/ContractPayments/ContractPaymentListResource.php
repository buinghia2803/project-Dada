<?php

namespace App\Http\Resources\Admin\ContractPayments;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractPaymentListResource extends JsonResource
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
            'selling_price' => $this->selling_price,
            'dad_price' => $this->dad_price,
            'artist_price' => $this->artist_price,
            'status' => $this->status,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'dividend' => $this->dividend,
            'full_name_dad' => $this->full_name_dad,
            'full_name_artist' => $this->full_name_artist,
        ];
    }
}
