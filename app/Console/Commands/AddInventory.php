<?php

namespace App\Console\Commands;

use App\Helpers\Util;
use App\inventory_master;
use App\Models\product;
use Illuminate\Console\Command;

class AddInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addInventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
//        $products = product::where('shop_id', 1)->get();
//        foreach ($products as $product) {
//        	$inventory_master = new inventory_master();
//        	$inventory_master->shop_id = 1;
//        	$inventory_master->facility_id = 1;
//        	$inventory_master->product_id = $product->product_id;
//        	$inventory_master->total_balance = 5000;
//        	$inventory_master->avgprice = 0;
//        	$inventory_master->regdate = Util::getNow();
//        	$inventory_master->invalid = 0;
//        	$inventory_master->save();
//		}
    }
}
