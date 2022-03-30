<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class despesaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $in;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($in)
    {
        $this->in = $in;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email');
    }
}
