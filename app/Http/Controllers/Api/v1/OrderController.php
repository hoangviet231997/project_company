<?php

namespace App\Http\Controllers\Api\v1;

use App\inventory_master;
use App\Models\order;
use App\Models\order_product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\Constant;

class OrderController extends Controller
{
    public function getListOrder(Request $request) {
        $data = order::getListOrder($request->date_from, $request->date_to, $request->shop_id, $request->status, $request->payment_status, $request->sell_method, $request->product_name, $request->code, $request->customer_id, 
        $request->customer_name, $request->customer_phone_number, $request->customer_email, $request->booking_type, 
        $request->booking_date_from, $request->booking_date_to, $request->staff_id, $request->no_pagination, $request->asset_id,
        $request->customer_keyword, $request->is_cancel_food, $request->is_discount, $request->is_surcharge);

    	return $this->respondSuccess($data);
    }

    public function getOrderDetail(Request $request) {
    	if($request->order_id) {
    		$order = order::getOrderAndOrderProductByOrderId($request->order_id, $request->shop_id);

    		return $this->respondSuccess($order);
		}
		else {
			return $this->respondMissingParam();
		}
	}

	public function reportDashboard(Request $request) {
        $shop_id = $request->input('shop_id');
        $shop_ids = $request->input('shop_ids');
        $shop_ids = is_array($shop_ids) ? $shop_ids : [$shop_id];
        $date_from = date('Y-m-d 00:00:01', strtotime('first day of last month'));
        $date_to = date('Y-m-d 23:59:59', strtotime('last day of this month'));
        $date_first_month = date('Y-m-d 00:00:01', strtotime('first day of this month'));
        $start_day = date('Y-m-d 00:00:01');
        $end_day = date('Y-m-d 23:59:59');
        $group_type = 'date(regdate_local)';


        $revenue = order::reportRevenueByshopId($shop_ids, $date_from, $date_to, 1);
        $order_in_month = order::reportNumberOrderByShopId($shop_ids, $date_from, $date_to, 1);
        $order_in_day = order::reportNumberOrderByShopId($shop_ids, $start_day, $end_day, 0);
        $product = inventory_master::reportProduct($shop_ids);
        $top_salse_product = order_product::reportTopSaleProduct($shop_ids);
        $revenue_chart = order::reportRevenueChartByShopId($shop_ids, $date_first_month, $date_to, $group_type);

        $data = [
            'revenue' => $revenue,
            'order' => $order_in_month,
            'report_today' => $order_in_day,
            'product_alert' => $product,
            'revenue_chart' => $revenue_chart,
            'product_top_sale_chart' => $top_salse_product
        ];

        return $this->respondSuccess($data);
    }

    public function updateOrderBookingStatus(Request $request){
        if($request->order_id && $request->type){
            $query = null;
            if($request->type == 1){
                $query = order::updateOrderBookingStatus($request->order_id, $request->shop_id, Constant::ORDER_CHECKIN);
            }
            else if($request->type == 2){
                $query = order::updateOrderBookingStatus($request->order_id, $request->shop_id, Constant::ORDER_CHECKOUT);
            }
            if($query){
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        return $this->respondMissingParam();
    }

}
