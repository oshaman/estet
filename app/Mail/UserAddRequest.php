<?php

namespace Fresh\Estet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAddRequest extends Mailable
{
    use Queueable, SerializesModels;

    protected $user_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('estet.email.add-user-request')->with('id', $this->user_id);
    }
}
