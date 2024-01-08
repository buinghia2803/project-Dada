<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailTemplate;
    protected $params;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailTemplate, $params = [])
    {
        if (!empty($mailTemplate->subject)) {
            $this->subject($mailTemplate->subject);
        }
        $this->template = $mailTemplate->parse($params);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->html('<html>' . $this->template . '</html>', 'text/html');
    }
}
