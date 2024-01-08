<?php
namespace App\Models;

use App\Models\BaseModel;

class Setting extends BaseModel
{
    protected $fillable = [
        'created_at',
        'id',
        'opensea_percent',
        'system_percent',
        'updated_at',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];
}
