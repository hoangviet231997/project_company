<?php

namespace App\Console\Commands;

use App\Helpers\Util;
use App\Imports\ProductsImport;
use App\Models\product;
use App\Models\product_category;
use App\Models\product_extend;
use App\Models\product_master;
use App\Models\product_unit;
use App\Models\unit_master;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProductExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importProductExcel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import product from excel file';

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
    	$this->info('change source code to import');
    	return;
    	
//		$arr = (new ProductsImport)->toArray('products.xls', 'import'); //giangson
		$arr = (new ProductsImport)->toArray('product_test.xls', 'import'); //shop test
//		$arr = (new ProductsImport)->toArray('test.xls', 'import');

		$shop_id = 2;

		foreach ($arr as $rows) {
			foreach ($rows as $row) {
//				print_r($row);
//				$this->info('----');

//				DB::beginTransaction();
				try{
					$product = new product();
					$product->shop_id = $shop_id;
					$product->owner_shop_id = $shop_id;
					$product->product_name = trim($row[2]);
					$product->info1 = trim($row[3]);

					$product_master = new product_master();
					$product_master->shop_id = $shop_id;
					$product_master->product_name = trim($row[2]);
					$product_master->info1 = trim($row[3]);

					if($product_category_name = trim($row[4])) { //category
						$product_category = product_category::where([
							'category_name' => $product_category_name,
							'shop_id' => $shop_id,
						])->first();
						if(!$product_category) {
							$product_category = new product_category();
							$product_category->shop_id = $shop_id;
							$product_category->category_name = $product_category_name;
							$product_category->category_group = 0;
							$product_category->status = 1;
							$product_category->parent_id = 0;
							$product_category->is_default = 0;
							$product_category->category_flag = 1;
							$product_category->save();
						}

						$product->product_category_id = $product_category->category_id;
						$product_master->product_category_id = $product_category->category_id;
					}

					$product->available = 1;

					$product_master->available = 1;
					$product_master->receiptflg = 1;
					$product_master->status_in_day = 1;
					$product_master->status = 1;
					$product_master->point_get_flg = 1;
					$product_master->online_sell_flg = 1;

					$product_master->save();

					$product->product_master_id = $product_master->product_master_id;
					$product->receiptflg = 1;
					$product->alert_flg = 0;
					$product->product_type = 1;
					$product->point_get_flg = 1;
					$product->online_sell_flg = 1;
					$product->save();

					if($unit_name = strtoupper(trim($row[9]))) {
						$unit = unit_master::where(['unitname' => $unit_name, 'shop_id' => $shop_id])->first();
						if(!$unit) {
							$unit = new unit_master();
							$unit->shop_id = $shop_id;
							$unit->unitname = $unit_name;
							$unit->invalid = 0;
							$unit->save();
						}
						$product->unit_id = $unit->id;
						$product->unit_name = $unit->unitname;

						$product_master->primary_unit_id = $unit->id;
						$product_master->primary_unit_name = $unit->unitname;

						$product_master_unit = product_unit::where([
							'product_master_id' => $product_master->product_master_id,
							'unit_id' => $unit->id,
							'is_primary' => 1,
							'shop_id' => $shop_id,
						])->first();

						if(!$product_master_unit) {
							$product_master_unit = new product_unit();
							$product_master_unit->shop_id = $shop_id;
							$product_master_unit->product_master_id = $product_master->product_master_id;
							$product_master_unit->unit_id = $unit->id;
							$product_master_unit->unit_name = $unit->unitname;
							$product_master_unit->unit_exchange = 1;
							$product_master_unit->price = intval($row[11]);
							$product_master_unit->is_primary = 1;
							$product_master_unit->regdate = Util::getNow();
							$product_master_unit->save();
						}
					}

					if(
						($unit2_name = strtoupper(trim($row[12]))) &&
						trim($row[9]) != trim($row[12])
					) {
						$unit2 = unit_master::where(['unitname' => $unit2_name, 'shop_id' => $shop_id])->first();
						if(!$unit2) {
							$unit2 = new unit_master();
							$unit2->shop_id = $shop_id;
							$unit2->unitname = $unit2_name;
							$unit2->invalid = 0;
							$unit2->save();
						}

						$product_master_unit2 = product_unit::where([
							'product_master_id' => $product_master->product_master_id,
							'unit_id' => $unit2->id,
							'unit_exchange' => intval($row[13]),
							'price' => intval($row[14]),
							'is_primary' => 0,
							'shop_id' => $shop_id,
						])->first();

						if(!$product_master_unit2) {
							$product_master_unit2 = new product_unit();
							$product_master_unit2->shop_id = $shop_id;
							$product_master_unit2->product_master_id = $product_master->product_master_id;
							$product_master_unit2->unit_id = $unit2->id;
							$product_master_unit2->unit_name = $unit2->unitname;
							$product_master_unit2->unit_exchange = intval($row[13]);
							$product_master_unit2->price = intval($row[14]);
							$product_master_unit2->is_primary = 0;
							$product_master_unit2->regdate = Util::getNow();
							$product_master_unit2->save();
						}
					}

					if(
						($unit3_name = strtoupper(trim($row[15]))) &&
						trim($row[9]) != trim($row[15])
					) {
						$unit3 = unit_master::where(['unitname' => $unit3_name, 'shop_id' => $shop_id])->first();
						if(!$unit3) {
							$unit3 = new unit_master();
							$unit3->shop_id = $shop_id;
							$unit3->unitname = $unit3_name;
							$unit3->invalid = 0;
							$unit3->save();
						}

						$product_master_unit3 = product_unit::where([
							'product_master_id' => $product_master->product_master_id,
							'unit_id' => $unit3->id,
							'unit_exchange' => intval($row[16]),
							'price' => intval($row[17]),
							'is_primary' => 0,
							'shop_id' => $shop_id,
						])->first();

						if(!$product_master_unit3) {
							$product_master_unit3 = new product_unit();
							$product_master_unit3->shop_id = $shop_id;
							$product_master_unit3->product_master_id = $product_master->product_master_id;
							$product_master_unit3->unit_id = $unit3->id;
							$product_master_unit3->unit_name = $unit3->unitname;
							$product_master_unit3->unit_exchange = intval($row[16]);
							$product_master_unit3->price = intval($row[17]);
							$product_master_unit3->is_primary = 0;
							$product_master_unit3->regdate = Util::getNow();
							$product_master_unit3->save();
						}
					}

					$product_master->product_barcode = $row[1];
					$product_master->default_price = intval($row[11]);
					$product_master->product_price = intval($row[11]);
					$product_master->save();

					$product->product_barcode = $row[1];
					$product->product_price = intval($row[11]);
					$product->buy_price = intval($row[18]);
					$product->save();

//					DB::commit();
				}
				catch(\Exception $e){
//					DB::rollBack();
					echo $e->getMessage();
				}
			}
		}

		//product extend
		$products = DB::table('product')
					  ->whereRaw("product_barcode != '' and shop_id = '$shop_id'")
					  ->get();

		foreach ($products as $product) {
			$product_extend = new product_extend();
			$product_extend->shop_id = $shop_id;
			$product_extend->product_id = $product->product_id;
			$product_extend->extend_barcode = $product->product_barcode;
			$product_extend->regdate = Util::getNow();
			$product_extend->save();
		}
    }
}
