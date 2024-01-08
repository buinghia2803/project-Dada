<?php
namespace App\Models;

use App\Models\BaseModel;

class Token extends BaseModel
{
    protected $fillable = [
        'id',
        'id_artist',
        'token_contract_offer',
        'token_confirm',
        'created_at',
        'updated_at',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];
}
