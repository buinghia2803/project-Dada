<?php
namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractPayment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'contract_offer_id',
        'contract_nft_id',
        'dad_price',
        'artist_price',
        'status',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];

    public function contractOffer()
    {
        return $this->hasOne(ContractOffer::class, 'id', 'contract_offer_id');
    }

    public function contractNft()
    {
        return $this->hasOne(ContractNft::class, 'id', 'contract_nft_id');
    }
}
