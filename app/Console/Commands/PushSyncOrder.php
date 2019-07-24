<?php

namespace App\Console\Commands;

use App\Helper\PushHelper;
use Illuminate\Console\Command;

class PushSyncOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushSyncOrder {order_id} {shop_id} {push_type} {--device_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command push sync order';

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
    	PushHelper::pushAppByOrderId($this->argument('order_id'), $this->argument('shop_id'), $this->argument('push_type'), $this->option('device_id'));
    }
}
