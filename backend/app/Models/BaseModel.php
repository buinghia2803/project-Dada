<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BaseModel extends Model
{
    /**
     * Load user model base on created_by
     *
     * @return Model
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Load user model base on created_by
     *
     * @return Model
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Get Created At Attribute
     *
     * @param  mixed $date
     * @return void
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->timezone(config('app.timezone'));
    }

    /**
     * Get Updated At Attribute
     *
     * @param  mixed $date
     * @return void
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->timezone(config('app.timezone'));
    }

    /**
     * Boot
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        //Conver datatime
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->format("Y-m-d H:i:s");
        });
        // create a event to happen on updating
        static::updating(function ($table) {
            if (auth()->check() && isset($table->created_by)) {
                $table->updated_by = auth()->guard('api')->user()->id;
            } elseif (isset($table->created_by)) {
                $table->updated_by = 1;
            }
        });

        // create a event to happen on saving
        static::creating(function ($table) {
            if (auth()->check() && isset($table->created_by)) {
                $table->created_by = auth()->guard('api')->user()->id;
                $table->updated_by = auth()->guard('api')->user()->id;
            } elseif (isset($table->created_by)) {
                $table->created_by = 1;
                $table->updated_by = 1;
            }
        });
    }
}
