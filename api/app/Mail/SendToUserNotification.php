<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendToUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->message;
        return $this->view('mail.usernofication')->with([
            'item' => $message
        ]);
    }
}
