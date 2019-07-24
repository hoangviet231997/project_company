<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerInventoryMasterAndCustomerInventoryDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $customer_inventory_master_sql = <<<EOD
CREATE TABLE `customer_inventory_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(200) DEFAULT NULL,
  `product_extend_id` int(11) DEFAULT NULL COMMENT 'ref product_extend.id',
  `batch_no` varchar(100) DEFAULT NULL COMMENT 'số lô',
  `batch_expire_date` date DEFAULT NULL COMMENT 'ngày hết hạn lô',
  `total_balance` int(11) DEFAULT NULL COMMENT 'số lượng tồn kho',
  `note` text,
  `expire_date` datetime DEFAULT NULL COMMENT 'ngày hết hạn sử dụng',
  `lastupdate` datetime DEFAULT NULL,
  `regdate` datetime DEFAULT NULL,
  `invalid` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`,`shop_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
EOD;
		DB::statement($customer_inventory_master_sql);

		$customer_inventory_detail_sql = <<<EOD
CREATE TABLE `customer_inventory_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(200) DEFAULT NULL,
  `product_status` varchar(0) DEFAULT NULL COMMENT 'trạng thái đơn hàng',
  `product_extend_id` int(11) NOT NULL,
  `batch_no` varchar(100) DEFAULT NULL COMMENT 'số lô',
  `batch_expire_date` date DEFAULT NULL COMMENT 'ngày hết hạn lô',
  `qty_prestock` double(11,3) DEFAULT NULL COMMENT 'tồn đầu ngày',
  `qty_receipt` double(11,3) DEFAULT NULL COMMENT 'nhập kho',
  `qty_issues` double(11,3) DEFAULT NULL COMMENT 'xuất kho',
  `note` text,
  `lastupdate` datetime DEFAULT NULL,
  `regdate` datetime DEFAULT NULL,
  `invalid` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`,`shop_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
EOD;
		DB::statement($customer_inventory_detail_sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
