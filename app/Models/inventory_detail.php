<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class inventory_detail extends Model
{
    protected $table = 'inventory_detail';
    public $timestamps = false;
    public $fillable = [
        'shop_id',
        'facility_id',
        'product_id',
        'product_extend_id',
        'product_status',
        'qty_prestock',
        'qty_receipt',
        'qty_return',
        'qty_stocktake',
        'qty_issues',
        'note',
    ];
    
    
    /**
     * @param $shop_id
     * @param $product_id
     * @param $product_extend_id
     * @param $facility_id
     * @param $quantity
     * @param $type
     * @param $sub_type
     * @param $regdate
     * @param $batch_no
     * @param $batch_expire_date
     */
    public static function createOrUpdateInventoryInDay(
        $shop_id,
        $product_id,
        $product_extend_id,
        $facility_id,
        $quantity,
        $type,
        $sub_type,
        $regdate,
        $batch_no,
        $batch_expire_date
    ) {
        $inventory_detail = self::checkExistsInventoryInDay($shop_id, $product_id, $product_extend_id, $facility_id, $regdate);

        self::resetPreStock($shop_id, $product_id, $product_extend_id, $regdate, $type, $quantity);

        if ($inventory_detail) {
            if ($type == 3) {
                $inventory_detail->qty_stocktake += $quantity;
            } else {
                if ($type == 1) {
                    $inventory_detail->qty_receipt += $quantity;
                } else {
                    if ($type == 2) {
                        if ($sub_type == 2) {
                            $inventory_detail->qty_return += $quantity;
                        } else {
                            $inventory_detail->qty_issues += $quantity;
                        }
                    }
                }
            }
            $inventory_detail->lastupdate = Carbon::now()->format('Y-m-d H:i:s');

            $inventory_detail->save();
        } else {
            $inventory_detail = new inventory_detail();
            $inventory_detail->shop_id = $shop_id;
            $inventory_detail->product_id = $product_id;
            $inventory_detail->product_extend_id = $product_extend_id;
            $inventory_detail->facility_id = $facility_id;
            $inventory_detail->invalid = 0;
            $inventory_detail->regdate = $regdate;
            $inventory_detail->batch_expire_date = $batch_expire_date;
            $inventory_detail->batch_no = $batch_no;
            $inventory_detail->qty_prestock = self::totalPreStock($shop_id, $facility_id, $product_id, $product_id, $regdate);
            if ($type == 3) {
                $inventory_detail->qty_stocktake = $quantity;
            } else {
                if ($type == 1) {
                    $inventory_detail->qty_receipt = $quantity;
                } else {
                    if ($type == 2) {
                        if ($sub_type == 2) {
                            $inventory_detail->qty_return = $quantity;
                        } else {
                            $inventory_detail->qty_issues = $quantity;
                        }
                    }
                }
            }
            $inventory_detail->save();
        }
    }


    /**
     * @param $shop_id
     * @param $product_id
     * @param $product_extend_id
     * @param $facility_id
     * @return mixed
     */
    public static function checkExistsInventoryInDay(
        $shop_id,
        $product_id,
        $product_extend_id,
        $facility_id,
        $regdate
    ) {
        $regdate = mb_substr(trim($regdate), 0, 10);
        $inventory_detail = inventory_detail::where([
            'shop_id' => $shop_id,
            'product_id' => $product_id,
            'product_extend_id' => $product_extend_id,
            'facility_id' => $facility_id,
            'invalid' => 0,
        ])->whereRaw("date(regdate) = '{$regdate}'")->first();

        return $inventory_detail;
    }


    /**
     * @param $shop_id
     * @param $facility_id
     * @param $product_id
     * @param $product_extend_id
     * @param $quantity
     * @param $type
     * @param $sub_type
     * @param $date
     * @return mixed
     */
    public static function editInventoryInDay(
        $shop_id,
        $facility_id,
        $product_id,
        $product_extend_id,
        $quantity,
        $type,
        $sub_type,
        $date
    ) {
        $today = mb_substr($date, 0, 10);

        $inventory_inday = inventory_detail::where([
            'shop_id' => $shop_id,
            'facility_id' => $facility_id,
            'product_id' => $product_id,
            'product_extend_id' => $product_extend_id,
            'invalid' => 0,
        ])->whereRaw("date(regdate) = '{$today}'")
            ->first();

        self::resetPreStock(
            $shop_id,
            $product_id,
            $product_extend_id,
            $date,
            $type,
            $quantity
        );

        if($inventory_inday) {
            $inventory_inday->qty_prestock = self::totalPreStock(
                $shop_id,
                $facility_id,
                $product_id,
                $product_extend_id,
                $today
            );

            if ($type == 1) {
                $inventory_inday->qty_receipt -= $quantity;
            } else if ($type == 3) {
                $inventory_inday->qty_stocktake -= $quantity;
            } else if ($type == 2) {
                if ($sub_type == 2) {
                    $inventory_inday->qty_return -= $quantity;
                } else {
                    $inventory_inday->qty_issues -= $quantity;
                }
            }
            $inventory_inday->save();
        }
        else {
            $data['msg_error'] = __('messages.canNotFoundResource');
            return $data;
        }
    }


    /**
     * @param $shop_id
     * @param $facility_id
     * @param $product_id
     * @param $product_extend_id
     * @param $today
     * @return int
     */
    protected static function totalPreStock(
        $shop_id,
        $facility_id,
        $product_id,
        $product_extend_id,
        $today
    ) {
        $today = mb_substr(trim($today), 0, 10);
        $inventory_detail = inventory_detail::where([
            'shop_id' => $shop_id,
            'facility_id' => $facility_id,
            'product_id' => $product_id,
            'product_extend_id' => $product_extend_id,
            'invalid' => 0,
        ])
            ->whereRaw("date(regdate) > '{$today}'")
            ->orderBy('regdate', 'desc')
            ->first();

        if($inventory_detail) {
            $total_prestock = (
                    $inventory_detail->qty_prestock +
                    $inventory_detail->qty_receipt +
                    $inventory_detail->qty_stocktake
                ) -
                (
                    $inventory_detail->qty_return +
                    $inventory_detail->qty_issues
                );
        }
        else {
            $total_prestock = 0;
        }

        return $total_prestock;
    }

    /**
     * reset pretock inday when cancel transaction
     * @param $shop_id
     * @param $product_id
     * @param $product_extend_id
     * @param $date
     * @param $type
     * @param $quantity
     * @return int
     */
    public static function resetPreStock(
        $shop_id,
        $product_id,
        $product_extend_id,
        $date,
        $type,
        $quantity
    ) {
        if($type == 1) {  // nếu hủy phiếu nhập thì từ quantity tương ứng
            $operator = '-';
        }
        else { // nếu hủy phiếu xuất, kiểm kho thì + quantity tương ứng, kiểm kho (+ (-quantity) input)
            $operator = '+';
        }

        $sql = <<<EOD
UPDATE inventory_detail
SET qty_prestock  = qty_prestock {$operator} {$quantity}
WHERE
	shop_id = '{$shop_id}'
AND product_id = '{$product_id}'
AND product_extend_id = '{$product_extend_id}'
AND regdate > '{$date}'
AND invalid = 0
EOD;

        return DB::update($sql);

    }

}
