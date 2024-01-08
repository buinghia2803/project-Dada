<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\ContractPayment;

class ContractOffer extends BaseModel
{
    const WAITING_SIGNING_STATUS = 0;
    const EFFECT_STATUS = 1;
    const REJECT_STATUS = 2;
    const SOLD_STATUS = 3;
    const EXPIRED_STATUS = 4;
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'dad_id',
        'artist_id',
        'date_start',
        'date_end',
        'token',
        'selling_price',
        'dad_percent',
        'artist_percent',
        'dad_price',
        'artist_price',
        'system_price',
        'opensea_price',
        'system_percent',
        'opensea_percent',
        'responsibility',
        'contact_info',
        'email',
        'status',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];

    /**
     * ContractNft
     *
     * @return void
     */
    public function contractNft()
    {
        return $this->belongsTo(ContractNft::class, 'id', 'contract_offer_id');
    }

    /**
     * Dad
     *
     * @return void
     */
    public function dad()
    {
        return $this->hasOne(User::class, 'id', 'dad_id');
    }

    /**
     * Artist
     *
     * @return void
     */
    public function artist()
    {
        return $this->hasOne(User::class, 'id', 'artist_id');
    }

    /**
     * ContractPayment
     *
     * @return void
     */
    public function contractPayment()
    {
        return $this->hasMany(ContractPayment::class, 'contract_offer_id', 'id');
    }
}
