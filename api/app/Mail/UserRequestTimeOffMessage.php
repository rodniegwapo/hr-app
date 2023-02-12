<?php

namespace App\Mail;

use App\Models\TimeOff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRequestTimeOffMessage extends Mailable
{
    use Queueable, SerializesModels;


    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('mail.timeoffrequest', [
            'user' => $this->data,
            'url' =>  env('APP_CLIENT_URL') ? env('APP_CLIENT_URL') : 'http://localhost:3000' . '/request' . '/?id=' . $this->data->id
        ]);
    }
}
