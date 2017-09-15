<?php

namespace Fresh\Estet\Console\Commands;

use Illuminate\Console\Command;
use Fresh\Estet\Repositories\SubscribersRepository;
use Fresh\Estet\Jobs\Dispatch;
use Illuminate\Support\Facades\Cache;

class SendNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendNews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mailing newsletters';

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

        $docs = $repository->getDocs();
        $patients = $repository->getPatients();
        if ($docs->isNotEmpty()) {
            $content = Cache::get('sub_doc');
            if (!empty($content)) {
                foreach ($docs as $doc) dispatch((new Dispatch($doc->email, $content))->onQueue('sibscriber'));
            }
        }

        if ($patients->isNotEmpty()) {
            $content = Cache::get('sub_patient');
            if (!empty($content)) {
                foreach ($patients as $patient) dispatch((new Dispatch($patient->email, $content))->onQueue('sibscriber'));
            }
        }
        \Log::info('Mailer update complite - '. date("d-m-Y H:i:s"));
    }
}
