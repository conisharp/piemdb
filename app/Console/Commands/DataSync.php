<?php

namespace App\Console\Commands;

use App\Services\Interfaces\IDataSyncService;
use Illuminate\Console\Command;

class DataSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'piemdb:datasync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize data in PieMDB';

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
     * @return int
     */
    public function handle(IDataSyncService $service)
    {
        $service->synchronize();
    }
}
