<?php

namespace App\Http\Resources\Admin\Revenue;

use App\Http\Resources\Admin\Dads\DadResource;
use App\Http\Resources\Admin\Artists\ArtistResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
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
            'sum_total_price' => $this->sum_total_price,
            'count_contract' => $this->count_contract,
            'sum_price_dad' => $this->sum_price_dad,
            'sum_price_artist' => $this->sum_price_artist,
            'sum_price_system' => $this->sum_price_system,
            'public_address_main' => $this->public_address_main,
            'public_address_sub' => $this->public_address_sub,
            'contract_address' => $this->contract_address,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'image_url' => $this->image_url,
            'positions' => $this->positions,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
