<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\SchedulerService;

class UpdateItemStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item:auctionexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if status is active and auction period has already expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->schedulerServ = new SchedulerService();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->schedulerServ
            ->checkSoldItems();

        return 0;
    }
}
