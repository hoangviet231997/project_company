<?php

namespace App\Models;

use App\Helper\Constant;
use App\Helpers\Util;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class order extends Model {
    protected $table = 'order';
	public $timestamps = false;
	protected $casts = ['id' => 'string'];
	public $incrementing = false;

	public function order_product() {
		return $this->hasMany(order_product::class, 'order_id', 'id')->where('order_product_invalid', 0);
	}

	private static function withOrderProduct($shop_id) {
		return order::with(['order_product' => function($query_sub) use ($shop_id) {
			$query_sub->where('shop_id', $shop_id);
		}]);
	}

	public static function getListOrder($date_from=null, $date_to=null, $shop_id, $status = null, 
	$payment_status = null, $sell_method = null, $product_name = null, $code = null, $customer_id=null,
	$customer_name=null, $customer_phone_number=null, $customer_email=null, $booking_type = null, $booking_date_from = null, 
	$booking_date_to = null, $staff_id = null, $no_pagination = null, $asset_id = null, $customer_keyword = null,
	$is_cancel_food = null, $is_discount = null, $is_surcharge = null) {
		$limit_pagination = $no_pagination ? Constant::MAX_LIMIT_PAGINATION : Constant::LIMIT_PAGINATION;

		if($date_from && !is_numeric($date_from)) {
			$date_from = strtotime(Util::getDateSearch($date_from));
		}

		if($date_to && !is_numeric($date_to)) {
			$date_to = strtotime(Util::getDateSearch($date_to, false));
		}

		$query = order::withOrderProduct($shop_id);

		$query->where([
			'order.shop_id' => $shop_id,
			'invalid' => 0,
		]);

		if($booking_type && $booking_date_from && $booking_date_to) {
			$booking_date_from = Util::getDateSearch($booking_date_from);
			$booking_date_to = Util::getDateSearch($booking_date_to, false);

			$booking_field = 'booking_time';
			if($booking_type == Constant::LIST_ORDER_BOOOKING_TYPE_CHECKIN) {
				$booking_field = 'checkin_time';
			}
			else if($booking_type == Constant::LIST_ORDER_BOOOKING_TYPE_CHECKOUT) {
				$booking_field = 'checkout_time';
			}

			$query->wherebetween($booking_field, array($booking_date_from, $booking_date_to));
		}

		if(!is_null($date_from) && !is_null($date_to)) {
			$query->wherebetween('regdate_business_date', array($date_from, $date_to));
		}

        if(!is_null($status)) {
            $query->whereIn('status', explode(',', $status));
		}

        if(!is_null($payment_status)) {
            $query->where('payment_status', $payment_status);
        }

        if(!is_null($sell_method)) {
            $query->where('sell_method', $sell_method);
        }

        if(!is_null($product_name)){
			$query->with('order_product')
			->whereHas('order_product', function($q) use($product_name) {
				$q->where('product_name','like', "%$product_name%");
			});
		}
		
		if(!is_null($code)){
			$query->where('code', 'like' , "%$code%");
		}

		if(!is_null($customer_id)){
			$query->where('customer_id', $customer_id);
		}

		if(!is_null($customer_name)){
			$query->where('customer_name', $customer_name);
		}

		if(!is_null($customer_phone_number)){
			$query->where('customer_phone_number', $customer_phone_number);
		}

		if(!is_null($customer_email)){
			$query->where('customer_email', $customer_email);
		}

		if(!is_null($staff_id)){
			$staff_sql = <<<EOD
(account_service_ids like '{$staff_id},%' or 
account_service_ids = '{$staff_id}' or 
account_service_ids like '%,{$staff_id}' or
account_service_ids like '%,{$staff_id},%')
EOD;
			$query->whereRaw($staff_sql);
		}

		if(!is_null($asset_id)){
			$query->where('asset_id', $asset_id);
		}

		if(!is_null($customer_keyword)) {
			$query->where(function ($q) use ($customer_keyword) {
				$q->orWhere('customer_name', 'like', "%$customer_keyword%")
				->orWhere('customer_email', 'like', "%$customer_keyword%")
				->orWhere('customer_phone_number', 'like', "%$customer_keyword%");
			});
		}

		if(!is_null($is_cancel_food) && $is_cancel_food == 1) {
			$query->with('order_product')
			->whereHas('order_product', function($q) {
				$q->where('status', 2);
			});
		}

		if(!is_null($is_discount) && $is_discount == 1) {
			$query->where('discount_price', '>', 0);
		}

		if(!is_null($is_surcharge) && $is_surcharge == 1) {
			$query->where('surcharge_price', '>', 0);
		}

		$query->orderByDesc('regdate_business_date');

        $query = $query->paginate($limit_pagination);

        $data = [
        	'total_items' => $query->total(),
			'item_per_page' => $limit_pagination,
			'current_page' => $query->currentPage(),
            'total_page' => ceil($query->total() / $limit_pagination),
			'orders' => $query->makeHidden('invalid')
        ];

        return $data;
    }

    public static function getOrderById($id, $shop_id) {
    	return order::where([
    		'id' => $id,
			'shop_id' => $shop_id,
			'invalid' => 0,
		])->first();
	}

	public static function getOrderProductByOrderId($order_id, $shop_id) {
    	return order_product::where([
    		'order_id' => $order_id,
    		'shop_id' => $shop_id,
    		'order_product_invalid' => 0,
		])->get();
	}

	public static function updateOrderAttributeByOrderId($order_id, $shop_id, $key, $val) {
    	order::where([
			'id' => $order_id,
			'shop_id' => $shop_id
		])->update([$key => $val]);
	}

	public static function updateOrderBookingStatus($order_id, $shop_id, $val) {
    	$query = order::where([
			'id' => $order_id,
			'shop_id' => $shop_id
		])->update(['status' => $val]);
		if(!$query){
			return false;
		}
		return true;
	}

	public static function getOrderAndOrderProductByOrderId($order_id, $shop_id) {
		return order::withOrderProduct($shop_id)->where([
			'id' => $order_id,
			'shop_id' => $shop_id,
			'invalid' => 0,
		])->first();
	}

	public static function getReport($date_from, $date_to, $shop_id, $asset_id = null) {
		//for test
//		$date_from = '2019-01-01';
//		$date_to = '2019-12-01';
		$status_cancel = Constant::ORDER_CANCEL;

		if($date_from && !is_numeric($date_from)) {
			$date_from = strtotime(substr($date_from, 0, 10).' 00:00:00');
		}

		if($date_to && !is_numeric($date_to)) {
			$date_to = strtotime(substr($date_to, 0, 10).' 23:59:59');
		}

		$query = order::where([
			'shop_id' => $shop_id,
			'invalid' => 0,
		]);

		if($asset_id) {
			$query->where('asset_id', $asset_id);
		}

		if($date_from && $date_to) {
			$query->wherebetween('business_date', [$date_from, $date_to]);
		}

		//order serve not filter business_date
		$query_customer_serve = clone $query;
		$query_customer_serve->select([
			DB::raw("ifnull(sum(person_num), 0) as customer_serve"),
			DB::raw("count(id) as count_order_serve"),
			DB::raw("ifnull(sum(grand_total), 0) as sum_order_serve"),
		]);
		$query_customer_serve->whereIn('status', Constant::$LIST_STATUS_SERVE_ARRAY);

		$query_deposit = clone $query;
		$query_deposit->select(DB::raw("ifnull(sum(if(paid_total > 0, paid_total, 0)), 0) as sum_total_deposit"));
		$query_deposit->whereNotIn('status', Constant::$LIST_STATUS_COMPLETED_ARRAY);

		$query_order_cancel = clone $query;
		$query_order_cancel->select([
			DB::raw("count(id) as count_order_cancel"),
			DB::raw("ifnull(sum(grand_total), 0) as sum_order_cancel"),
		]);
		$query_order_cancel->where('status', Constant::ORDER_CANCEL);

		$query->whereIn('status', Constant::$LIST_STATUS_SERVED_ARRAY);

		$query->select([
			DB::raw("ifnull(sum(paid_total), 0) as sum_total_paid"),
			DB::raw("ifnull(sum(grand_total - paid_total), 0) as sum_total_debt"),
			DB::raw("ifnull(sum(discount_price), 0) as sum_total_discount"),
			DB::raw("ifnull(sum(surcharge_price), 0) as sum_total_surcharge"),
			DB::raw("ifnull(sum(person_num), 0) as customer_served"),
			DB::raw("count(id) as count_order_served"),
			DB::raw("ifnull(sum(if(discount_price, 1, 0)), 0) as count_order_discount"),
			DB::raw("ifnull(sum(if(surcharge_price, 1, 0)), 0) as count_order_surcharge"),
			DB::raw("ifnull(sum(if(discount_price, paid_total, 0)), 0) as sum_order_discount"),
			DB::raw("ifnull(sum(if(surcharge_price, paid_total, 0)), 0) as sum_order_surcharge"),
		]);

		$asset_id_sql = '';
		if($asset_id) {
			$asset_id_sql = " and `order`.asset_id = '{$asset_id}'";
		}

		$query_order_product_cancel_sql = <<<EOD
select
	count(*) as count_order_product_cancel,
	ifnull(sum(grand_total), 0) as sum_order_product_cancel 
from (
	select `order`.id, `order`.grand_total
	from `order`
	inner join `order_product` on `order`.`id` = `order_product`.`order_id` and (`order_product`.`shop_id` = '{$shop_id}' and `order_product_invalid` = 0 and `order_product`.`order_product_status` = '{$status_cancel}') 
where `order`.`shop_id` = '{$shop_id}' and `order`.`invalid` = 0 and `order`.`status` <> '{$status_cancel}' and
`order`.`business_date` between '{$date_from}' and '{$date_to}'
{$asset_id_sql}
group by `order_product`.`order_id`
) tmp
EOD;

		$query_order_product = order_product::select([
			DB::raw("order_product.product_name COLLATE 'utf8_bin' as product_name"),
			DB::raw("ifnull(sum(order_product.number), 0) as sum_num"),
			DB::raw("ifnull(sum(order_product.number * if(order_product.discount_price > 0, order_product.price - order_product.discount_price, order_product.price)), 0) as sum_price"),
		]);

		if($asset_id) {
			$query_order_product->leftJoin('order', 'order_product.order_id', 'order.id');
			$query_order_product->where('order.asset_id', $asset_id);
		}

		$query_order_product->where([
			'order_product.shop_id' => $shop_id,
			'order_product.order_product_invalid' => 0,
		]);
		$query_order_product->whereIn('order_product.order_product_status', Constant::$LIST_STATUS_SERVED_ARRAY);

		if($date_from && $date_to) {
			$query_order_product->wherebetween('order_product.order_product_business_date', [$date_from, $date_to]);
		}
		$query_order_product->groupBy('order_product.product_name');
		$query_order_product->orderByDesc('sum_price');

		$result = $query->first()->toArray();
		$result_deposit = $query_deposit->first()->toArray();
		$result_customer_serve = $query_customer_serve->first()->toArray();
		$result_order_cancel = $query_order_cancel->first()->toArray();
		$result_order_product_cancel = DB::select($query_order_product_cancel_sql)[0];
		$result_order_products = $query_order_product->get()->toArray();

		$result_order_product_total_price = collect($result_order_products)->sum('sum_price');

		foreach ($result_order_products as &$result_order_product) {
			$result_order_product['percent'] = $result_order_product_total_price ? round(100 * $result_order_product['sum_price'] / $result_order_product_total_price, 2) : 0;
		}

		$data = [
			'sum_total' => $result['sum_total_paid'] + $result_deposit['sum_total_deposit'],
			'sum_total_paid' => $result['sum_total_paid'],
			'sum_total_debt' => $result['sum_total_debt'],
			'sum_total_deposit' => $result_deposit['sum_total_deposit'],
        	'sum_total_discount' => $result['sum_total_discount'],
			'sum_total_surcharge' => $result['sum_total_surcharge'],
        	'customer_served' => $result['customer_served'],
			'customer_serve' => $result_customer_serve['customer_serve'],
        	'count_order_served' => $result['count_order_served'],
			'sum_order_served' => $result['sum_total_paid'],
        	'count_order_serve' => $result_customer_serve['count_order_serve'],
        	'sum_order_serve' => $result_customer_serve['sum_order_serve'],
			'count_order_cancel' => $result_order_cancel['count_order_cancel'],
			'sum_order_cancel' => $result_order_cancel['sum_order_cancel'],
			'count_order_product_cancel' => $result_order_product_cancel->count_order_product_cancel,
			'sum_order_product_cancel' => $result_order_product_cancel->sum_order_product_cancel,
			'count_order_discount' => $result['count_order_discount'],
			'sum_order_discount' => $result['sum_order_discount'],
			'count_order_surcharge' => $result['count_order_surcharge'],
			'sum_order_surcharge' => $result['sum_order_surcharge'],
			'product_proportion' => $result_order_products,
		];

		return $data;
	}

	public static function reportRevenueByshopId($shop_ids, $date_from, $date_to, $type) {
	    $data = order::select(DB::raw('sum(total) as total'), 'regdate_local')
            ->whereIn('shop_id', $shop_ids)
            ->whereBetween('regdate_local', [$date_from, $date_to])
            ->where('invalid', 0)
            ->where('status', '<>', Constant::ORDER_CANCEL);

        if($type)
            $data = $data->groupBy(DB::raw('month(regdate_local)'));

        $data = $data->orderBy('regdate_local', 'asc')->get();
        $revenue = [];
	    foreach ($data as $item) {
	        if(mb_substr($item->regdate_local, 5, 2) == mb_substr($date_from, 5, 2)) {
                $revenue['last_month'] = $item->total;
            }
            else {
                $revenue['this_month'] = $item->total;
            }
        }
        $revenue['this_month'] = !isset($revenue['this_month']) ? 0 : $revenue['this_month'];
        $revenue['last_month'] = !isset($revenue['last_month']) ? 0 : $revenue['last_month'];
        return $revenue;
    }

    public static function reportNumberOrderByShopId($shop_ids, $date_from, $date_to, $type) {
        $revenue = '';
	    if(!$type) {
	        $revenue = ', sum(if(status !=5, total, 0)) as revenue';
        }
	    $data = order::select(
            DB::raw('sum(if(status = 5, 1, 0)) as cancel' . $revenue),
            DB::raw('count(id) as total'),
            'regdate_local'
        )
            ->whereIn('shop_id', $shop_ids)
            ->where('invalid', 0)
            ->whereBetween('regdate_local', [$date_from, $date_to]);

	    if($type)
            $data = $data->groupBy(DB::raw('month(regdate_local)'));

        $data = $data->orderBy('regdate_local', 'asc')->get();
        $order = [];
        if($type) {
            foreach ($data as $item) {
                if (mb_substr($item->regdate_local, 5, 2) == mb_substr($date_from, 5, 2)) {
                    $order['last_month'] = [
                        'completed' => $item->total - $item->cancel,
                        'cancel' => $item->cancel ?? 0,
                    ];
                } else {
                    $order['this_month'] = [
                        'completed' => $item->total - $item->cancel,
                        'cancel' => $item->cancel ?? 0,
                    ];
                }
            }
            if (!isset($order['last_month'])) {
                $order['last_month'] = ['completed' => 0, 'cancel' => 0];
            }
            if (!isset($order['this_month'])) {
                $order['this_month'] = ['completed' => 0, 'cancel' => 0];
            }
        }
        else {
            foreach ($data as $item){
                $order['order'] = [
                    'completed' => $item->total - $item->cancel,
                    'cancel' => $item->cancel ?? 0,
                ];
                $order['revenue'] = $item->revenue ?? 0;
            }
            $order['revenue'] = !isset($order['revenue']) ? 0 : $order['revenue'];
            if(!isset($order['order'])) {
                $order['order'] = ['conpleted' => 0, 'cancel' => 0];
            }
        }

        return $order;
    }

    public static function reportRevenueChartByShopId($shop_ids, $date_from, $date_to, $group_type) {
        $data_revenue = $data_revenue_report = [];
        $count_day = Carbon::createFromFormat('Y-m-d H:i:s', $date_to)->daysInMonth;
        $data = self::select(
	        'regdate_local',
            DB::raw('sum(total) as total')
        )
            ->whereIn('shop_id', $shop_ids)
            ->where('invalid', 0)
            ->where('status', '<>', Constant::ORDER_CANCEL)
            ->whereBetween('regdate_local', [$date_from, $date_to])
            ->groupBy(DB::raw($group_type))
            ->orderBy('regdate_local', 'asc')
            ->get();
	    foreach ($data as $item) {
	        $day_temp = intval(mb_substr($item->regdate_local, 5, 2));
	        $data_revenue['revenue'][$day_temp] = $item->total;
	        $data_revenue['day'][$day_temp] = $day_temp;
        }
        for ($i = 1; $i <= $count_day; $i++) {
            if(!isset($data_revenue['day'][$i])){
                $data_revenue_report['revenue'][] = 0;
                $data_revenue_report['day'][] = $i;
            }
            else {
                $data_revenue_report['revenue'][] = $data_revenue['revenue'][$i] / 1000;
                $data_revenue_report['day'][] = $data_revenue['day'][$i];
            }
        }
        return $data_revenue_report;
	}

}
