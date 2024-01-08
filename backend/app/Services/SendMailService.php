<?php

namespace App\Services;

use App\Services\BaseService;
use App\Jobs\SendMailTemplate;

class SendMailService extends BaseService
{
    /**
     * Send Mail
     */
    public function sendMail($typeSix, $email, $paramsUrl)
    {
        SendMailTemplate::dispatch($typeSix, $email, $paramsUrl);
    }
}
