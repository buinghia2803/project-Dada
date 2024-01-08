<?php
namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'action',
        'type',
        'sender_type',
        'status',
        'date_public',
        'created_at',
        'updated_at',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];
}
