<?php

namespace Fresh\Estet\Console\Commands;

use Illuminate\Console\Command;
use Fresh\Estet\Repositories\SubscribersRepository;

class getSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getSubscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get new articles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repository = new SubscribersRepository();
        $res = $repository->getAll();
        $res ? $this->info('Update success!') : $this->info('Update fail!');
        \Log::info('Subscribers update complite - '. date("d-m-Y H:i:s"));
    }
}
