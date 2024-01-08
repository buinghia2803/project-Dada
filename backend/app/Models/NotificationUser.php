<?php
namespace App\Models;

use App\Models\BaseModel;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationUser extends BaseModel
{
    use HasFactory;


    const SENDER_TYPE_ADMIN_SEND = 1;
    const SENDER_TYPE_DAD_SEND = 2;
    const SENDER_TYPE_ARTIST_SEND = 3;

    const TYPE_SEND_ALL_DAD = 1;
    const TYPE_SEND_ALL_ARTIST = 2;
    const TYPE_SEND_ALL_SYSTEM = 3;

    const ROLE_DAD = 1;
    const ROLE_ARTIST = 2;

    protected $fillable = [
        'id',
        'notification_id',
        'admin_id',
        'user_from',
        'user_to',
        'status',
        'created_at',
        'updated_at',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];

    public function notification()
    {
        return $this->hasOne(Notification::class, 'id', 'notification_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }

    public function userForm()
    {
        return $this->hasOne(User::class, 'id', 'user_from');
    }

    public function userTo()
    {
        return $this->hasOne(User::class, 'id', 'user_to');
    }
}
