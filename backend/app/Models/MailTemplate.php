<?php

namespace App\Models;

use App\Models\BaseModel;

class MailTemplate extends BaseModel
{
    protected $fillable = [
        'id',
        'subject',
        'content',
        'type',
        'created_at',
        'updated_at',
    ];


    public $selectable = [
        '*',
    ];

    public $sortable = [];

    public function parse($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
            if (isset($data[trim($index)])) {
                return $data[trim($index)];
            }
        }, $this->content);

        return $parsed;
    }
}
