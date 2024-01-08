<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\ContractOffer;

class User extends Authenticatable
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;

    protected $guard = 'user_api';

    // use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'public_address_main',
        'public_address_sub',
        'contract_address',
        'email',
        'full_name',
        'image_url',
        'positions',
        'description',
        'type',
        'status',
        'created_at',
        'updated_at',
        'deteted_at',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];


    /**
     * ContractOfferDad
     *
     * @return void
     */
    public function contractOfferDad()
    {
        return $this->hasOne(ContractOffer::class, 'dad_id', 'id');
    }

    /**
     * ContractOfferArtist
     *
     * @return void
     */
    public function contractOfferArtist()
    {
        return $this->hasOne(ContractOffer::class, 'artist_id', 'id');
    }
}
