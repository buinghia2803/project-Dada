<?php
namespace App\Models;

use App\Models\BaseModel;

class Permission extends BaseModel
{
    protected $fillable = [
        "id",
        "name",
        "guard_name",
        "type",
        "is_deleted",
        "created_at",
        "updated_at",
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];
}
