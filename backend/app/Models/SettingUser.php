<?php
namespace App\Models;

use App\Models\BaseModel;
use App\Models\User;

class SettingUser extends BaseModel
{
    const SENDER_TYPE_ADMIN_SEND = 1;
    const SENDER_TYPE_DAD_SEND = 2;
    const SENDER_TYPE_ARTIST_SEND = 3;

    const TYPE_SEND_ALL_DAD = 1;
    const TYPE_SEND_ALL_ARTIST = 2;
    const TYPE_SEND_ALL_SYSTEM = 3;

    const ROLE_DAD = 1;
    const ROLE_ARTIST = 2;

    const STATUS_SENT = 1;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'user_id',
        'contract_notify',
        'system_notify',
    ];

    public $selectable = [
        '*',
    ];

    public $sortable = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
