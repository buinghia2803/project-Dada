<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
//    protected $primaryKey = 'email';

    const UPDATED_AT = null;

    public $selectable = [
        '*',
    ];

    protected $fillable = [
        'email',
        'token',
        'created_by',
        'updated_by',
    ];
}
