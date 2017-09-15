<?php

namespace Fresh\Estet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use Fresh\Estet\Mail\UserAddRequest;

class SendUserAddEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user_id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new UserAddRequest($this->user_id);
        $moders = ['reg_forall@bigmir.net', 'oshaman789@gmail.com', 'shaman78@ukr.net'];
        Mail::to($moders)->send($email);
        \Log::info('UserAddEmail');
    }
}
