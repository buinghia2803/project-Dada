<?php

namespace App\Models;

use App\Models\BaseModel;

class ContractNft extends BaseModel
{
    const STATUS = [
        'wait_for_confirm' => 0,
        'approve' => 1,
        'reject' => 2,
        'approve_opensea' => 3,
        'reject_opensea' => 4
    ];

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'contract_offer_id',
        'name',
        'image_url',
        'description',
        'token_url',
        'address_contract',
        'token_contract',
        'gas_fee',
        'status',
        'created_at ',
        'updated_at ',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];

    public function contractOffer()
    {
        return $this->hasOne(ContractOffer::class, 'id', 'contract_offer_id');
    }
}
