<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\area
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $shop_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\area whereUpdatedAt($value)
 */
	class area extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\customer_supplier
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $name
 * @property string|null $image
 * @property int|null $groupid tham chiêu customer_supplier_group
 * @property string|null $address
 * @property string|null $tel
 * @property string|null $notes
 * @property int|null $invalid
 * @property string|null $tax_code
 * @property string|null $email
 * @property string|null $website
 * @property int|null $customer_flg  =1 : khach hang
 * @property int|null $supplier_flg 1: supplier
 * @property float|null $debt
 * @property int|null $priceplan khong dung thay the = customergroupid
 * @property int|null $allow_order_flg
 * @property string|null $regdate
 * @property string|null $birthday
 * @property string|null $barcode
 * @property float|null $fee_ship
 * @property int|null $price_policy_id
 * @property string|null $customer_sex
 * @property int|null $payment_method refer asset
 * @property string|null $extra_info1
 * @property string|null $extra_info2
 * @property int|null $order_count
 * @property int|null $pricegroup_update_flg 1: update customer_groupid se update price_policy_id = customer_groupid. price_policy_id
 * @property int|null $membercard_type hang the vang bac ..= point card id
 * @property int|null $total_earn_point
 * @property float|null $total_buy_amount
 * @property float|null $total_remain_amount so tien du chua duoc tich diem dung khi point_setting.fixedmode =0
 * @property string|null $rankcard_start_date
 * @property string|null $cardrank_expire_date
 * @property int|null $status 0: normal  1: đang tich diem
 * @property string|null $password
 * @property string|null $email_password
 * @property string|null $otp_code
 * @property int $otp_verify_flg
 * @property string|null $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereAllowOrderFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereCardrankExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereCustomerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereCustomerSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereEmailPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereExtraInfo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereExtraInfo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereFeeShip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereGroupid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereMembercardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereOtpVerifyFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier wherePricePolicyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier wherePricegroupUpdateFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier wherePriceplan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereRankcardStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereSupplierFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereTotalBuyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereTotalEarnPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereTotalRemainAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier whereWebsite($value)
 */
	class customer_supplier extends \Eloquent {}
}

namespace App{
/**
 * App\inventory_transaction
 *
 * @property int $id
 * @property int $shop_id
 * @property float|null $transaction_masterid refer transaction_master
 * @property int|null $version_code
 * @property string|null $account_id tài khoản nhập
 * @property string|null $account_name
 * @property int|null $product_id
 * @property string|null $product_name
 * @property string|null $product_code mã hàng hóa
 * @property int $product_extend_id map product_extend
 * @property string|null $batch_no tên lô
 * @property string|null $batch_expire_date hết hạn
 * @property float|null $quantity số lượng nhập/xuất tinh tren / unitname (not primary unit)  . Truong hop kiem kho : pre_stocktake - stocktake_qunantiy
 * @property int|null $unit_id id đơn vị tính
 * @property string|null $unit_name don vi tinh: thùng
 * @property float|null $primary_unit_convert quy đổi về đơn vị gốc 1 thùng = 24lon
 * @property float|null $sellvat %vat
 * @property float|null $sellprice giá bán ra dự tính
 * @property float|null $costprice giá nhập xuất
 * @property float|null $costvat vat luc nhap
 * @property float|null $discount % giảm giá
 * @property float|null $total tổng tiền
 * @property float|null $stocktake_quanity giá trị kiểm kê kho
 * @property string|null $note ghi chú
 * @property string|null $regdate
 * @property string|null $regdate_local
 * @property int|null $type
 * @property int|null $sub_type
 * @property string|null $update
 * @property string|null $update_local
 * @property string|null $printdate
 * @property int|null $status 0: tam; 1: xong
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereBatchExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereCostprice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereCostvat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction wherePrimaryUnitConvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction wherePrintdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereProductExtendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereRegdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereSellprice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereSellvat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereStocktakeQuanity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereTransactionMasterid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereUpdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_transaction whereVersionCode($value)
 */
	class inventory_transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\inventory_transaction_master_search
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $bill_regdate
 * @property int|null $version_code
 * @property string|null $code mã hoá đơn
 * @property int|null $source_type 1: bán hàng
 * @property float|null $source_id soure type =1 -> soure id = order_id
 * @property int|null $type  1: nhập, 2: Xuất, 3 Kiểm kho
 * @property int|null $sub_type 1: Nhập
 * 	1: mua
 * 	2: nhập hủy HD,
 * 	3: nhập nội bộ
 * 	4: nhập chuyển
 * 	5: nhập tồn
 * 	7: khách hàng trả lại
 * 	8: nhập từ nhà cung cấp
 * 2: Xuất
 * 	1: do bán hàng
 * 	2: xuất trả hàng
 * 	3: xuat nội bộ
 * 	4: xuất chuyển
 * 	5: xuất hủy
 * 	6: xuất định lượng bán hàng
 * 	8: xuất trả nhà cung cấp
 * 3: Kiểm kho
 * 4: Phiếu cấp phát
 * @property int|null $expensesflg 1: phat sinh phieu chi nhap hang
 * @property int|null $asset_id
 * @property string|null $asset_name
 * @property int|null $transaction_with_id id nhà cung cấp hoặc khách hàng
 * @property string|null $transaction_with_name tên nhà cung cấp hoặc khách hàng
 * @property string|null $orderdate ngày giờ nhập hoá đơn
 * @property int|null $account_id tài khoản tạo phiếu nhập
 * @property string|null $account_name
 * @property int|null $discount_id
 * @property string|null $discount_reason
 * @property float|null $discount_price
 * @property float|null $discount_percent
 * @property string|null $cancel_reason
 * @property float|null $total tổng tiền
 * @property float|null $tax_price
 * @property float|null $tax_percent
 * @property float|null $tax
 * @property float|null $shipping
 * @property float|null $paidTotal thanh toán
 * @property int|null $invalid
 * @property string|null $note ghi chú
 * @property int|null $status 0:xong, 1:tạm, 5:hủy
 * @property string|null $dateCreated ngày giờ nhập
 * @property string|null $last_update
 * @property string|null $master_local_regdate
 * @property string|null $itm_regdate
 * @property float|null $shift_local_id
 * @property int $payment_status 1: đã thanh toán, 2: thanh toán 1 phần, 3: chưa thanh toán
 * @property int|null $facility_id
 * @property int|null $shop_id_provided
 * @property int|null $shop_id_receive
 * @property int $facility_id_receive
 * @property float $source_id2 map id transaction master receive
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereAssetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereBillRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereCancelReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereDateCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereDiscountReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereExpensesflg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereFacilityIdReceive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereItmRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereMasterLocalRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereOrderdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search wherePaidTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereShiftLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereShopIdProvided($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereShopIdReceive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereSourceId2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereSourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereTransactionWithId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereTransactionWithName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master_search whereVersionCode($value)
 */
	class inventory_transaction_master_search extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\transaction
 *
 * @property int $id
 * @property float|null $local_id
 * @property int|null $version_code
 * @property string|null $code
 * @property string|null $account_id
 * @property string|null $account_name
 * @property int $shop_id
 * @property int|null $shift_id
 * @property int|null $auto_type 0: thu cong; 1: tu dong
 * @property int|null $frequent_type 0: ko thuong xuyen; 1: thuong xuyen
 * @property int|null $type 1: thu; 2: chi
 * @property int|null $sub_type 1: tham chieu ,  2: phiếu chi do hủy hoa don ban hang , 3: phieu chi do huy phieu thu , 4: phieu thu do huy phieu chi
 * @property int|null $asset_id
 * @property string|null $asset_name
 * @property int|null $status 0: tam; 1: xong
 * @property float|null $pre_amount ton dau công nợ KH, NCC
 * @property float|null $amount amount = input_amount + surcharge+ feeship-discount
 * @property float|null $debt_amount no còn lại chưa thanh toán của phiếu thu này
 * @property float|null $after_amount ton cuoi công no KH , NCC
 * @property float|null $input_amount thu chi : amout = so tien nhap. Neu ban hang KH thieu no -> amount =  total - paid'
 * @property float|null $total total doanh thu = amount + phu thu - giam gia + ship
 * @property float|null $total_asset total quỹ tiền
 * @property int|null $soure_type 1: từ order; 2: từ thu nơ KH ; 3: tra no nha cung cap; 4: inventory; 10: hủy thu order; 11: hủy thu khác; 12: hủy chi , 13 : chuyển ví
 * @property float|null $soure_id souretype =1 -> soure id = order id; sourcetype = 2 -> source id = transaction_local_id (cong no -> tra no theo hoa don) ,  sourcetype = 4 -> source id = transaction inventory master id, souretype =13 -> soureid = gốc ví chuyển
 * @property int|null $whowith_id
 * @property string|null $whowith_name
 * @property int|null $category transaction category
 * @property string|null $note
 * @property string|null $regdate
 * @property string|null $regdate_local
 * @property string|null $update
 * @property string|null $update_local
 * @property string|null $printdate
 * @property string|null $printdate_local
 * @property int|null $invalid
 * @property int|null $customer_debt_flg 0: khong tinh phat sinh cong no khach hang   1: tinh thong ke phat sinh cong no khach hang
 * @property int|null $transaction_business_date
 * @property float|null $transaction_balance tính công nợ trừ dần cho từng phiếu thu chi . Nếu =0 phiếu này đã hoàn tất tính vào công nợ KH
 * @property string|null $transaction_refer_ids
 * @property float|null $transaction_surcharge
 * @property float|null $transaction_discount
 * @property float|null $transaction_fee_ship
 * @property int|null $revenueship_flg 0: không tính phí ship vào doanh thu; 1: tính phí ship vào doanh thu
 * @property int|null $report_flg cờ có tính trong doanh thu hay không
 * @property int|null $presave_transaction_id
 * @property int|null $transaction_ignore 0: phieu thu, chi normal , 1: tinh doanh hoac chi phi khong phat quy tien
 * @property int|null $is_open_shift
 * @property int|null $is_deposit transaction đặt cọc
 * @property float|null $shift_local_id
 * @property int|null $open_close_shift_type 0: bt; 1: open; 2: close
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAfterAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAssetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereAutoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereCustomerDebtFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereDebtAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereFrequentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereInputAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereIsDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereIsOpenShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereOpenCloseShiftType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction wherePreAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction wherePresaveTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction wherePrintdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction wherePrintdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereRegdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereReportFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereRevenueshipFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereShiftLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereSoureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereSoureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTotalAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionBusinessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionFeeShip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionIgnore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionReferIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereTransactionSurcharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereUpdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereVersionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereWhowithId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\transaction whereWhowithName($value)
 */
	class transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\shop_order_statistic
 *
 * @property int $id
 * @property int|null $shop_id
 * @property string|null $prefix_order_code
 * @property int|null $total_order
 * @property string|null $expire_date
 * @property int|null $expire_order_code loại reset order code. 1: ngày; 2: tháng; 3: năm
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic whereExpireOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic wherePrefixOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_order_statistic whereTotalOrder($value)
 */
	class shop_order_statistic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\order_product
 *
 * @property string $id
 * @property int $shop_id
 * @property float $order_id
 * @property int|null $order_product_version_code
 * @property int $product_id
 * @property int|null $product_master_id ref product_master
 * @property string|null $product_name ref product
 * @property int|null $product_extend_id ref product_extend
 * @property int|null $product_unit_type
 * @property string|null $batch_no ref product_extend
 * @property string|null $batch_expire_date ref product_extend
 * @property int|null $unit_id
 * @property string|null $unit_name
 * @property int $unit_type
 * @property int|null $primary_unit_convert
 * @property int|null $number
 * @property float $price
 * @property float|null $discount_price
 * @property float|null $discount_percent
 * @property string|null $discount_reason
 * @property float|null $product_tax_percent
 * @property float|null $product_tax_price
 * @property string|null $cancel_reason
 * @property string|null $transfer_from
 * @property string|null $note_product
 * @property int|null $shift_id
 * @property string|null $paid_date local paiddate time
 * @property int|null $type
 * @property string|null $extra_name
 * @property string|null $price_extra
 * @property string|null $combo
 * @property string|null $regdate
 * @property string|null $last_update
 * @property int|null $status 1 normal, 2 cancel
 * @property int|null $order_product_status
 * @property int|null $order_product_extra_status 1: order; 3: đang chế biến; 9: hoàn tất
 * @property string|null $regdate_local
 * @property string|null $last_update_local
 * @property string|null $print_date_local
 * @property string|null $name_sort_order_food
 * @property int|null $order_index_order_food
 * @property string|null $extra json chứa option có price >0
 * @property string|null $paid_regdate server paid date time
 * @property int|null $order_product_invalid
 * @property float|null $order_product_inprice
 * @property int|null $order_product_business_date
 * @property int|null $promotion_detail_id neu food duoc chon tu promotion detail thi gan promotiondetail_id = promotiondetail.id
 * @property float|null $original_reflocalitem
 * @property string|null $itemextra_memo1
 * @property string|null $itemextra_memo2
 * @property int|null $price_policy_id
 * @property int|null $order_product_account_id
 * @property string|null $order_product_account_name
 * @property int|null $order_product_category_id
 * @property string|null $order_product_category_name
 * @property float|null $order_product_parent_id local id
 * @property int|null $inventory_created_flg
 * @property string|null $commission
 * @property int|null $product_type 1: hàng hóa; 2: dịch vụ; 3: combo; 100: web teamplate; 101: pos service
 * @property int|null $area_id
 * @property string|null $area_name
 * @property int|null $table_id
 * @property string|null $table_name
 * @property string|null $from_time
 * @property string|null $to_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereBatchExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereCancelReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereCombo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereDiscountReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereExtraName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereFromTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereInventoryCreatedFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereItemextraMemo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereItemextraMemo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereLastUpdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereNameSortOrderFood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereNoteProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderIndexOrderFood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductBusinessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductExtraStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductInprice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOrderProductVersionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereOriginalReflocalitem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePaidRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePriceExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePricePolicyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePrimaryUnitConvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePrintDateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductExtendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereProductUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product wherePromotionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereRegdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereToTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereTransferFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_product whereUnitType($value)
 */
	class order_product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\inventory_transaction_master
 *
 * @property string $id
 * @property int $shop_id
 * @property string|null $bill_regdate
 * @property int|null $version_code
 * @property string|null $code mã hoá đơn
 * @property int|null $source_type 1: bán hàng
 * @property float|null $source_id soure type =1 -> soure id = order_id
 * @property int|null $type  1: nhập, 2: Xuất, 3 Kiểm kho
 * @property int|null $sub_type 1: Nhập
 * 	1: mua
 * 	2: nhập hủy HD,
 * 	3: nhập nội bộ
 * 	4: nhập chuyển
 * 	5: nhập tồn
 * 	7: khách hàng trả lại
 * 	8: nhập từ nhà cung cấp
 * 2: Xuất
 * 	1: do bán hàng
 * 	2: xuất trả hàng
 * 	3: xuat nội bộ
 * 	4: xuất chuyển
 * 	5: xuất hủy
 * 	6: xuất định lượng bán hàng
 * 	8: xuất trả nhà cung cấp
 * 3: Kiểm kho
 * 4: Phiếu cấp phát
 * @property int|null $expensesflg 1: phat sinh phieu chi nhap hang
 * @property int|null $asset_id
 * @property string|null $asset_name
 * @property int|null $transaction_with_id id nhà cung cấp hoặc khách hàng
 * @property string|null $transaction_with_name tên nhà cung cấp hoặc khách hàng
 * @property string|null $orderdate ngày giờ nhập hoá đơn
 * @property int|null $account_id tài khoản tạo phiếu nhập
 * @property string|null $account_name
 * @property int|null $discount_id
 * @property string|null $discount_reason
 * @property float|null $discount_price
 * @property float|null $discount_percent
 * @property string|null $cancel_reason
 * @property float|null $total tổng tiền
 * @property float|null $tax_price
 * @property float|null $tax_percent
 * @property float|null $tax
 * @property float|null $shipping
 * @property float|null $paidTotal thanh toán
 * @property int|null $invalid
 * @property string|null $note ghi chú
 * @property int|null $status 0:xong, 1:tạm, 5:hủy
 * @property string|null $dateCreated ngày giờ nhập
 * @property string|null $last_update
 * @property string|null $master_local_regdate
 * @property string|null $itm_regdate
 * @property float|null $shift_local_id
 * @property int $payment_status 1: đã thanh toán, 2: thanh toán 1 phần, 3: chưa thanh toán
 * @property int|null $facility_id
 * @property int|null $shop_id_provided
 * @property int|null $shop_id_receive
 * @property int $facility_id_receive
 * @property float $source_id2 map id transaction master receive
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereAssetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereBillRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereCancelReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereDateCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereDiscountReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereExpensesflg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereFacilityIdReceive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereItmRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereMasterLocalRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereOrderdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master wherePaidTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereShiftLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereShopIdProvided($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereShopIdReceive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereSourceId2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereSourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereTransactionWithId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereTransactionWithName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\inventory_transaction_master whereVersionCode($value)
 */
	class inventory_transaction_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product
 *
 * @property int $product_id
 * @property int $shop_id
 * @property int|null $owner_product_id procduct id của sản phẩm gốc
 * @property int|null $owner_shop_id shop id của sản phẩm gốc
 * @property int|null $product_master_id
 * @property string|null $product_master_code
 * @property string|null $product_name
 * @property string|null $product_code
 * @property string|null $product_barcode
 * @property string|null $info1 hoat tinh
 * @property string|null $info2 nuoc san xuat
 * @property string|null $info3 so dang ky
 * @property string|null $info4 quy cach dong goi
 * @property string|null $info5 ham luong
 * @property string|null $info6 hang san xuat
 * @property string|null $short_name
 * @property int|null $available kich hoat
 * @property int|null $receiptflg co ban theo don thuoc
 * @property int|null $product_category_id
 * @property float|null $product_tax thue bán
 * @property int|null $unit_id id đơn vị tính (cái, hộp, ngày , tháng , năm ..)
 * @property string|null $unit_name tên đơn vị
 * @property int|null $product_unit_type 0: minute; 1: hour; 2 day
 * @property int|null $alert_flg 1: alert , 0: ko alert
 * @property float|null $alert_minval cảnh báo dưới mức
 * @property float|null $alert_maxval cảnh báo trên mức
 * @property int|null $service_unit_value thời gian sử dụng dịch vụ theo unit_id
 * @property int|null $service_promotion khuyễn mãi trên dơn vị promotion_unit , mua 1 năm tặng 2 tháng
 * @property int|null $promotion_unit 1: ngay 2 : thang  3: nam
 * @property float|null $product_price giá bán mặc định
 * @property float|null $in_price giá vốn hàng bán
 * @property float|null $buy_price giá mua mặc định
 * @property string|null $product_material đinh lượng nguyên vật liệu
 * @property string|null $combo cấu hình combo hàng hoá
 * @property string|null $eng_name
 * @property int|null $top_flg
 * @property int|null $direct_sell_flg
 * @property int|null $point_get_flg
 * @property int|null $online_sell_flg
 * @property int|null $reseller_flg
 * @property string|null $last_update
 * @property int|null $invalid 1: xóa, 2: ngừng kinh doanh
 * @property string|null $nameSortproduct
 * @property int|null $orderIndexproduct
 * @property int|null $group_price_id
 * @property int|null $product_type 1: hàng hóa, 2: dịch vụ, 3: combo   100: web teamplate 101 : pos service
 * @property int|null $manage_type 0: non serialize 1: serialize
 * @property string|null $serialnum moi item duoc danh mã vạch riêng
 * @property string|null $place_tag json encode table id
 * @property int|null $supplier_id
 * @property string|null $supplier_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereAlertFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereAlertMaxval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereAlertMinval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereCombo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereDirectSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereGroupPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInfo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInfo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInfo3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInfo4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInfo5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInfo6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereManageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereNameSortproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereOnlineSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereOrderIndexproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereOwnerProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereOwnerShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product wherePlaceTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product wherePointGetFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductMasterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereProductUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product wherePromotionUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereReceiptflg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereResellerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereSerialnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereServicePromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereServiceUnitValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereTopFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product whereUnitName($value)
 */
	class product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\order
 *
 * @property string $id
 * @property string|null $code
 * @property int|null $is_fast_payment
 * @property int|null $status NEW = 0, IN_PROCESS = 1, WRAP = 2, DELIVERY = 3, COMPLETED = 4, CANCEL = 5, MERGED = 8, CHECKIN = 10, CHECKOUT = 11; ORDER_BOOKING = 12
 * @property int|null $extra_status 1: order; 3: đang chế biến; 9: hoàn tất
 * @property int|null $table_status order stage
 * @property int|null $type 1: shop here; 2: take away; 3: delivery; 4: user here; 5: user delivery
 * @property string|null $type_name
 * @property int|null $stage_id
 * @property string|null $note
 * @property int|null $person_num
 * @property string $order_account_id
 * @property string|null $order_account_name
 * @property string|null $cashier_id
 * @property string|null $cashier_name
 * @property int|null $customer_id
 * @property string|null $customer_name
 * @property string|null $customer_phone_number
 * @property string|null $customer_email
 * @property int $shop_id
 * @property int|null $area_id
 * @property string|null $area_name
 * @property int|null $table_id
 * @property string|null $table_name
 * @property int|null $asset_id
 * @property string|null $audio_url
 * @property int|null $shift_id
 * @property string|null $shift_name
 * @property float|null $shift_local_id
 * @property float|null $tablegroup_price
 * @property int|null $tablegroup_price_id
 * @property int|null $promotion_id
 * @property string|null $cancel_reason
 * @property int|null $discount_id
 * @property float|null $discount_price
 * @property float|null $discount_percent
 * @property string|null $discount_reason
 * @property int|null $surcharge_id
 * @property float|null $surcharge_price
 * @property float|null $surcharge_percent
 * @property string|null $surcharge_reason
 * @property float|null $shipping_price
 * @property string|null $tax order tax
 * @property float|null $tax_price
 * @property float|null $tax_percent
 * @property float|null $total_discount_price_items
 * @property float|null $paid_total
 * @property float|null $total
 * @property float|null $grand_total
 * @property int|null $payment_status 0: chưa thanh toán; 1: thanh toán hoàn toàn; 2: thanh toán 1 phần
 * @property string|null $multipay_method
 * @property string|null $device_id
 * @property string $regdate
 * @property string $last_update
 * @property string $regdate_local
 * @property string $last_update_local
 * @property string|null $booking_time
 * @property string|null $checkin_time
 * @property string|null $checkout_time
 * @property string|null $paid_date
 * @property string|null $print_date
 * @property string|null $return_date
 * @property int|null $times_printed
 * @property int|null $version_code
 * @property int|null $version_code_change_order
 * @property int|null $is_shop 0: user order; 1: shop order;
 * @property int|null $delivery_service_id
 * @property int|null $invalid
 * @property int|null $regdate_business_date
 * @property int|null $business_date
 * @property int|null $last_update_timestamp
 * @property int $sell_method 0: không bán theo hóa đơn, 1: bán theo hóa đơn
 * @property string|null $account_service_ids danh sách account id liên quan đến service trong order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\order_product[] $order_product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereAccountServiceIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereAudioUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereBookingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereBusinessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCancelReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCashierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCheckinTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCheckoutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereCustomerPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereDeliveryServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereDiscountReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereExtraStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereIsFastPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereIsShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereLastUpdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereLastUpdateTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereMultipayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereOrderAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereOrderAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order wherePaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order wherePaidTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order wherePersonNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order wherePrintDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order wherePromotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereRegdateBusinessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereRegdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereSellMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereShiftLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereShiftName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereShippingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereSurchargeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereSurchargePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereSurchargePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereSurchargeReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTableStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTablegroupPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTablegroupPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTimesPrinted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTotalDiscountPriceItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereVersionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order whereVersionCodeChangeOrder($value)
 */
	class order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\restrict_duplicate_request
 *
 * @property int $id
 * @property string|null $action
 * @property float|null $local_id
 * @property int|null $shop_id
 * @property string|null $regdate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request whereLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\restrict_duplicate_request whereShopId($value)
 */
	class restrict_duplicate_request extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\app_shop
 *
 * @property int $id
 * @property int $app_identify_id
 * @property int|null $shop_id
 * @property string|null $shop_name
 * @property int|null $role_permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\product[] $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\product_category[] $product_category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereAppIdentifyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereRolePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereShopName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_shop whereUpdatedAt($value)
 */
	class app_shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\account_commission
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $account_id
 * @property int|null $commission_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_commission whereShopId($value)
 */
	class account_commission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\promotion
 *
 * @property int $id
 * @property int|null $shop_id
 * @property int|null $promotion_type 0: tang mon 1: giam gia hoa don 2: giam gia mon  3: tang gia hoa don; 4: tang gia mon; 5: giam gia hoa don theo KH; 6: goi dich vu
 * @property int|null $promotion_subtype 0: theo %; 1: theo số tiền
 * @property int|null $promotion_subtype2 0: ---; 1: Mua món tặng món
 * @property float|null $promotion_value
 * @property string|null $promotion_code
 * @property string|null $promotion_name
 * @property string|null $promotion_desc
 * @property string|null $promotion_image
 * @property int|null $target_type 0: ap dung toan bo  1~: ap dung nhóm  khách hàng  (target_detailtype = shop_customer.priceplan)  2 : áp dụng cho hạng thẻ (target_detailtype =  shop_membercard.cardtype)
 * @property string|null $target_detailtype
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $is_weekdays
 * @property string|null $weekdays 0: chu nhat , 1: thu 2 ...
 * @property int|null $is_time
 * @property string|null $start_time
 * @property string|null $to_time
 * @property int|null $condition_flag 0: ko có; 1: hóa đơn; 2: theo món
 * @property string|null $condition_detail json: order_cond; food_cond (array)
 * @property string|null $promotion_extra_condition thiết lập theo số lần giảm giá hóa đơn theo KH
 * @property int|null $promotion_subtype2_option Hàng tặng không nhân theo số lượng mua
 * @property string|null $regdate
 * @property string|null $lastupdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereConditionDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereConditionFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereIsTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereIsWeekdays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereLastupdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionExtraCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionSubtype2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionSubtype2Option($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion wherePromotionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereTargetDetailtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereTargetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereToTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion whereWeekdays($value)
 */
	class promotion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\promotion_detail
 *
 * @property int $id
 * @property int|null $promotion_id
 * @property int|null $food_id
 * @property string|null $food_name
 * @property float|null $amount so luong mon (truong hop tang mon)
 * @property int|null $food2_id trường hợp mua món tặng món
 * @property string|null $food2_name trường hợp mua món tặng món
 * @property float|null $amount2 trường hợp mua món tặng món
 * @property float|null $amount_used
 * @property float|null $discount_type 0 : giam % 1 : giam truc tiep số tiền
 * @property float|null $discount_value % 0.01  hoac so tien phu thuoc vao
 * @property float|null $change_price có thể tăng hoặc giảm phụ thuộc vào promotiontype = giam gia hay phụ thu
 * @property int|null $is_category nếu is_category = 1 thì food_id, food_name là menu_id và menu_name
 * @property int|null $is_category2 nếu is_category2 = 1 thì food2_id, food2_name là menu2_id và menu2_name
 * @property int|null $is_all
 * @property int|null $is_all2
 * @property string|null $regdate
 * @property string|null $lastupdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereAmount2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereAmountUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereChangePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereFood2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereFood2Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereFoodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereIsAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereIsAll2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereIsCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereIsCategory2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereLastupdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail wherePromotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\promotion_detail whereRegdate($value)
 */
	class promotion_detail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\order_type_master
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $order_type
 * @property string|null $description
 * @property string|null $regdate
 * @property int $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master whereOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\order_type_master whereShopId($value)
 */
	class order_type_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\account
 *
 * @property int $id
 * @property int $main_shopid shop trung tâm của chi nhánh này
 * @property string|null $username
 * @property string|null $password
 * @property string|null $password_temp
 * @property string|null $key_active
 * @property int|null $customer_supplier_group_id
 * @property string|null $email
 * @property string|null $full_name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $district
 * @property int|null $role
 * @property int|null $role_shop regist shop role_shop =1 chủ tài khoản
 * @property int|null $is_shop
 * @property int|null $is_fb_account
 * @property string|null $address_book
 * @property int|null $client_id
 * @property int|null $push_flg
 * @property string|null $regdate
 * @property string|null $last_update_date
 * @property int|null $login_count
 * @property int|null $is_chain
 * @property string|null $reset_pass_date
 * @property int|null $is_allow_chain
 * @property int|null $is_reset_password
 * @property string|null $orderpass nhap pass : nhap so
 * @property string|null $langcode vi :vietnam; en: english; ja: japanese
 * @property string|null $timework
 * @property int|null $maxshop
 * @property int $available
 * @property-read \App\Models\account_shop $main_account_shop
 * @property-read \App\Models\shop $main_shop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereAddressBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereCustomerSupplierGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereIsAllowChain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereIsChain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereIsFbAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereIsResetPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereIsShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereKeyActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereLangcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereLastUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereLoginCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereMainShopid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereMaxshop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereOrderpass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account wherePasswordTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account wherePushFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereResetPassDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereRoleShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereTimework($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account whereUsername($value)
 */
	class account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\shop
 *
 * @property int $id
 * @property int|null $main_shopid shopid chi nhánh chính; nếu = 0 bản thân shop là chi nhánh chính
 * @property int|null $account_id
 * @property string|null $name
 * @property string|null $tel
 * @property string|null $email
 * @property int|null $city
 * @property int|null $district
 * @property string|null $address
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $image
 * @property string|null $web_title
 * @property string|null $logo_image
 * @property string|null $description
 * @property string|null $extra
 * @property string|null $tax
 * @property int|null $type 1: pharmacy; 2: spa; 3: distributor; 4: retail
 * @property int|null $status
 * @property string|null $langcode
 * @property string|null $region
 * @property string|null $timezone
 * @property string|null $country_code vn: vietnam; jp:japan
 * @property int $public_shop_flg
 * @property string|null $ip
 * @property int|null $date_of_week_start 0: thứ 2; 1: thứ 3
 * @property string|null $business_start_hour giờ bắt đầu kinh doanh
 * @property string|null $open_hour giờ mở cửa
 * @property string|null $show_date_format định dạng ngày local
 * @property string|null $format_currency
 * @property int|null $max_num
 * @property int|null $auto_trans_flg 1: not auto; 2: end day; 3: base on bill
 * @property int|null $shift_flg 0: get default shift; 1: get shift by shop id
 * @property int|null $auto_shift 0: lấy shift đang mở ca, nếu ko có mở ca thì lấy app gửi lên; 1: server tự lấy shift
 * @property int|null $table_type 0: default; 1: dùng table name của app; 2: server tự động generate
 * @property int|null $sync_flg 1: data syn server; 2: data not sync
 * @property string|null $sync_date
 * @property float|null $rate
 * @property int|null $rate_times
 * @property int|null $priority
 * @property string|null $regdate
 * @property string|null $last_update_date
 * @property int|null $total_order_day
 * @property int|null $total_order_year
 * @property int|null $total_promotion_year
 * @property int|null $course_id
 * @property string|null $expire_date
 * @property int|null $expire_flg
 * @property string|null $propack_expire_date
 * @property int|null $trial_flg
 * @property string|null $lastuse_date
 * @property int|null $usedate_num
 * @property string|null $invite_code
 * @property int|null $manager_account_id nv cham soc shop tham chieu manager_account
 * @property int|null $register_channel 1: web; 2: android app; 3: ios app; 4: google ads; 5: fb ads
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereAutoShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereAutoTransFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereBusinessStartHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereDateOfWeekStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereExpireFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereFormatCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereInviteCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereLangcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereLastUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereLastuseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereLogoImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereMainShopid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereManagerAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereMaxNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereOpenHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop wherePropackExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop wherePublicShopFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereRateTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereRegisterChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereShiftFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereShowDateFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereSyncDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereSyncFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTotalOrderDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTotalOrderYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTotalPromotionYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereTrialFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereUsedateNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop whereWebTitle($value)
 */
	class shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\asset_amount_log
 *
 * @property int $id
 * @property int|null $asset_id
 * @property int $shop_id
 * @property float|null $pre_asset_total
 * @property float|null $asset_total
 * @property float|null $after_asset_total
 * @property string|null $datelog_business_date business date theo ngày
 * @property int|null $datelog_business_date_timestamp business date theo ngày (timestamp)
 * @property string|null $lastupdate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereAfterAssetTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereAssetTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereDatelogBusinessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereDatelogBusinessDateTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereLastupdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log wherePreAssetTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset_amount_log whereShopId($value)
 */
	class asset_amount_log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_category_search
 *
 * @property int $category_id
 * @property int $shop_id
 * @property string|null $category_name nhom hang hoa
 * @property int|null $category_group product type: 0: Dược phẩm; 1: Vật tư y tế; 2: Hàng hóa khác; 3: Hàng hoá; 4: Dịch vụ; 5: Gói dịch vụ; 6: Khác
 * @property int|null $status trang thai 1: available
 * @property string|null $category_desc ghi chu
 * @property string|null $category_small_thumbnail
 * @property int|null $parent_id
 * @property int|null $lang
 * @property int|null $is_default default: 0 shop; 1 system
 * @property int|null $top_flg
 * @property int|null $category_flag
 * @property int|null $manage_flag
 * @property string|null $nameSortcategorys
 * @property string|null $extra_category
 * @property string|null $last_update
 * @property int|null $invalid
 * @property int|null $orderIndexcategorys
 * @property int|null $pricegroup 0: nhom category thuc don  1: nhom category gia normal  2: nhom category gia theo gio 3: nhom category gia theo ngay
 * @property float|null $category_parent_local_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategoryDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategoryFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategoryGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategoryParentLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereCategorySmallThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereExtraCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereManageFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereNameSortcategorys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereOrderIndexcategorys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search wherePricegroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category_search whereTopFlg($value)
 */
	class product_category_search extends \Eloquent {}
}

namespace App{
/**
 * App\inventory_master
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $facility_id id kho hang ref facility_master.id
 * @property int|null $product_id
 * @property int|null $product_extend_id ref product_extend.id
 * @property string|null $batch_no số lô
 * @property string|null $batch_expire_date ngày hết hạn lô
 * @property int|null $total_balance so lượng tồn kho
 * @property float|null $avgprice trung bình giá vốn hàng tồn kho
 * @property string|null $note
 * @property string|null $lastupdate
 * @property string|null $regdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereAvgprice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereBatchExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereLastupdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereProductExtendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_master whereTotalBalance($value)
 */
	class inventory_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\account_push
 *
 * @property int $id
 * @property int|null $account_id
 * @property int|null $shop_id
 * @property string|null $push_id
 * @property string|null $device_id
 * @property int|null $device_type 0: android; 1: ios
 * @property int|null $app_type 0: android, 1: ios user, 2: ios manager
 * @property int|null $is_push
 * @property string|null $build_version
 * @property string|null $device_name
 * @property string|null $os_version
 * @property string|null $langcode
 * @property string|null $regdate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereAppType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereBuildVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereIsPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereLangcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereOsVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push wherePushId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_push whereShopId($value)
 */
	class account_push extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\debug_log
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $log
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\debug_log whereUpdatedAt($value)
 */
	class debug_log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_master_search
 *
 * @property int $product_master_id
 * @property int $shop_id
 * @property string|null $product_name
 * @property string|null $product_code
 * @property string|null $product_barcode
 * @property string|null $feature {{ id:1, name=‘color’, value= [ {item:’xanh’, price:’10,000’,  available:’1’, alertflg:’1’, min_alert:’200’} ] }{ id:2, name=‘size’,   value=  [ {item:’M’, price:’10,000’,  available:’1’, alertflg:’1’, min_alert:’300’} ] }}
 * @property string|null $rack_info
 * @property string|null $info1 hoat tinh
 * @property string|null $info2 nuoc san xuat
 * @property string|null $info3 so dang ky
 * @property string|null $info4 quy cach dong goi
 * @property string|null $info5 ham luong
 * @property string|null $info6 hang san xuat
 * @property string|null $description mo ta
 * @property string|null $short_name
 * @property int|null $available kich hoat
 * @property int|null $receiptflg co ban theo don thuoc
 * @property int|null $product_category_id
 * @property float|null $default_price gia dang ky
 * @property float|null $product_tax thue
 * @property int|null $primary_unit_id id  don vi co ban
 * @property string|null $primary_unit_name
 * @property int|null $product_unit_type 0: minute; 1: hour; 2 day
 * @property float|null $product_price gia ban
 * @property string|null $eng_name
 * @property string|null $product_thumbnail1
 * @property string|null $product_thumbnail2
 * @property string|null $product_thumbnail3
 * @property string|null $product_thumbnail4
 * @property string|null $product_desc
 * @property int|null $status_in_day
 * @property int|null $status
 * @property int|null $lang
 * @property float|null $rate
 * @property int|null $rate_times
 * @property int|null $top_flg
 * @property int|null $direct_sell_flg bán tại cửa hàng
 * @property int|null $point_get_flg sp tích luỹ điềm
 * @property int|null $online_sell_flg cho phép bán online
 * @property int|null $reseller_flg cho phép người khác bán hỗ
 * @property int|null $product_type 1: hàng hóa, 2: dịch vụ, 3: combo   100: web teamplate 101 : pos service
 * @property int|null $materials_flg
 * @property string|null $price_extra
 * @property string|null $product_material đinh lượng nguyên vật liệu
 * @property string|null $combo cấu hình combo hàng hoá
 * @property int|null $batch_flg 1: quản lý lô sẽ ko sinh ra product khi tạo product master
 * @property string|null $last_update
 * @property int|null $invalid 1: xóa, 2: ngừng kinh doanh
 * @property string|null $nameSortproduct
 * @property int|null $orderIndexproduct
 * @property string|null $place_tag json encode table id
 * @property int|null $supplier_id
 * @property string|null $supplier_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereBatchFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereCombo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereDirectSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInfo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInfo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInfo3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInfo4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInfo5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInfo6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereMaterialsFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereNameSortproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereOnlineSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereOrderIndexproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search wherePlaceTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search wherePointGetFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search wherePriceExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search wherePrimaryUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search wherePrimaryUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductThumbnail1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductThumbnail2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductThumbnail3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductThumbnail4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereProductUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereRackInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereRateTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereReceiptflg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereResellerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereStatusInDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master_search whereTopFlg($value)
 */
	class product_master_search extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\customer_inventory
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $customer_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property int|null $product_extend_id ref product_extend.id
 * @property string|null $batch_no số lô
 * @property string|null $batch_expire_date ngày hết hạn lô
 * @property int|null $total_balance số lượng tồn kho
 * @property string|null $note
 * @property string|null $expire_date ngày hết hạn sử dụng
 * @property \Illuminate\Support\Carbon|null $lastupdate
 * @property \Illuminate\Support\Carbon|null $regdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereBatchExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereLastupdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereProductExtendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_inventory whereTotalBalance($value)
 */
	class customer_inventory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\dealer_commission
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $dealer_id
 * @property int|null $commission_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission whereDealerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\dealer_commission whereShopId($value)
 */
	class dealer_commission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\commission_master
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $customer_supplier_group_id
 * @property int|null $product_id
 * @property int|null $product_amount
 * @property float|null $commission_percent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master whereCommissionPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master whereCustomerSupplierGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master whereProductAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\commission_master whereShopId($value)
 */
	class commission_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_master
 *
 * @property int $product_master_id
 * @property int $shop_id
 * @property string|null $product_name
 * @property string|null $product_code
 * @property string|null $product_barcode
 * @property string|null $feature {{ id:1, name=‘color’, value= [ {item:’xanh’, price:’10,000’,  available:’1’, alertflg:’1’, min_alert:’200’} ] }{ id:2, name=‘size’,   value=  [ {item:’M’, price:’10,000’,  available:’1’, alertflg:’1’, min_alert:’300’} ] }}
 * @property string|null $rack_info
 * @property string|null $info1 hoat tinh
 * @property string|null $info2 nuoc san xuat
 * @property string|null $info3 so dang ky
 * @property string|null $info4 quy cach dong goi
 * @property string|null $info5 ham luong
 * @property string|null $info6 hang san xuat
 * @property string|null $description mo ta
 * @property string|null $short_name
 * @property int|null $available kich hoat
 * @property int|null $receiptflg co ban theo don thuoc
 * @property int|null $product_category_id
 * @property float|null $default_price gia dang ky
 * @property float|null $product_tax thue
 * @property int|null $primary_unit_id id  don vi co ban
 * @property string|null $primary_unit_name
 * @property int|null $product_unit_type 0: minute; 1: hour; 2 day
 * @property float|null $product_price gia ban
 * @property string|null $eng_name
 * @property string|null $product_thumbnail1
 * @property string|null $product_thumbnail2
 * @property string|null $product_thumbnail3
 * @property string|null $product_thumbnail4
 * @property string|null $product_desc
 * @property int|null $status_in_day
 * @property int|null $status
 * @property int|null $lang
 * @property float|null $rate
 * @property int|null $rate_times
 * @property int|null $top_flg
 * @property int|null $direct_sell_flg bán tại cửa hàng
 * @property int|null $point_get_flg sp tích luỹ điềm
 * @property int|null $online_sell_flg cho phép bán online
 * @property int|null $reseller_flg cho phép người khác bán hỗ
 * @property int|null $product_type 1: hàng hóa, 2: dịch vụ, 3: combo   100: web teamplate 101 : pos service
 * @property int|null $materials_flg
 * @property string|null $price_extra
 * @property string|null $product_material đinh lượng nguyên vật liệu
 * @property string|null $combo cấu hình combo hàng hoá
 * @property int|null $batch_flg 1: quản lý lô sẽ ko sinh ra product khi tạo product master
 * @property string|null $last_update
 * @property int|null $invalid 1: xóa, 2: ngừng kinh doanh
 * @property string|null $nameSortproduct
 * @property int|null $orderIndexproduct
 * @property string|null $place_tag json encode table id
 * @property int|null $supplier_id
 * @property string|null $supplier_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereBatchFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereCombo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereDirectSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInfo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInfo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInfo3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInfo4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInfo5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInfo6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereMaterialsFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereNameSortproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereOnlineSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereOrderIndexproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master wherePlaceTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master wherePointGetFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master wherePriceExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master wherePrimaryUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master wherePrimaryUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductThumbnail1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductThumbnail2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductThumbnail3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductThumbnail4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereProductUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereRackInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereRateTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereReceiptflg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereResellerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereStatusInDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_master whereTopFlg($value)
 */
	class product_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\rack_master
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $rack_name
 * @property int $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master whereRackName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\rack_master whereShopId($value)
 */
	class rack_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\shop_setting
 *
 * @property int $id
 * @property int|null $shop_id
 * @property int|null $show_top_flg hiển thị top app user
 * @property int|null $order_flg
 * @property int|null $delivery_flg
 * @property int|null $fastbuy_flg
 * @property int|null $news_flg
 * @property float|null $price_per_person
 * @property int|null $price_per_person_flg
 * @property int|null $check_wifi_flg
 * @property int|null $required_login_flg required user login
 * @property int|null $is_quick_payment_in_order_screen
 * @property int|null $point_setting_flg 1:ap dung chuong trinh tich diem
 * @property int|null $inprice_export_tran_report_flg 0: chi giá vốn không tính vào quỹ tiền; 1: chi giá vốn tính vào quỹ tiền
 * @property string|null $show_qr_code_in_bill
 * @property int|null $print_phone_flg
 * @property int|null $print_address_flg
 * @property int|null $print_note_flg
 * @property int|null $print_inout_time_flg
 * @property int|null $print_column_amount_temp_flg
 * @property int|null $print_order_number_product_flg
 * @property int|null $print_payment_flg
 * @property int|null $preview_print_flg
 * @property int|null $change_color_when_print_temp
 * @property string|null $thank_bill
 * @property int|null $show_inprice_export_trans_flg
 * @property int|null $revenueship_flg
 * @property int|null $setting_stop_rental_service
 * @property int $order_stage_id_subtract_inventory
 * @property int $select_shift_when_order
 * @property int $create_customer_send_sms_flg
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereChangeColorWhenPrintTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereCheckWifiFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereCreateCustomerSendSmsFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereDeliveryFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereFastbuyFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereInpriceExportTranReportFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereIsQuickPaymentInOrderScreen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereNewsFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereOrderFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereOrderStageIdSubtractInventory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePointSettingFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePreviewPrintFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePricePerPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePricePerPersonFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintAddressFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintColumnAmountTempFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintInoutTimeFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintNoteFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintOrderNumberProductFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintPaymentFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting wherePrintPhoneFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereRequiredLoginFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereRevenueshipFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereSelectShiftWhenOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereSettingStopRentalService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereShowInpriceExportTransFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereShowQrCodeInBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereShowTopFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\shop_setting whereThankBill($value)
 */
	class shop_setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\account_shop
 *
 * @property int $id
 * @property int|null $account_id
 * @property int $shop_id shop account được quyền access
 * @property string|null $shop_name
 * @property int|null $role_permission_id
 * @property string|null $token token dùng để xác định sẽ thực hiện thao tác shop nào
 * @property int|null $mainshop_flg 1 : tru so chinh
 * @property string|null $regdate
 * @property-read \App\Models\account|null $account
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereMainshopFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereRolePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereShopName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\account_shop whereToken($value)
 */
	class account_shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_unit
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $product_master_id
 * @property int|null $unit_id
 * @property string|null $unit_name
 * @property int|null $unit_exchange
 * @property float|null $price
 * @property int|null $alert_flg
 * @property int $is_primary
 * @property string|null $regdate
 * @property int $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereAlertFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereProductMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereUnitExchange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_unit whereUnitName($value)
 */
	class product_unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\customer_supplier_search
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $name
 * @property string|null $image
 * @property int|null $groupid tham chiêu customer_supplier_group
 * @property string|null $address
 * @property string|null $tel
 * @property string|null $notes
 * @property int|null $invalid
 * @property string|null $tax_code
 * @property string|null $email
 * @property string|null $website
 * @property int|null $customer_flg  =1 : khach hang
 * @property int|null $supplier_flg 1: supplier
 * @property float|null $debt
 * @property int|null $priceplan khong dung thay the = customergroupid
 * @property int|null $allow_order_flg
 * @property string|null $regdate
 * @property string|null $birthday
 * @property string|null $barcode
 * @property float|null $fee_ship
 * @property int|null $price_policy_id
 * @property string|null $customer_sex
 * @property int|null $payment_method refer asset
 * @property string|null $extra_info1
 * @property string|null $extra_info2
 * @property int|null $order_count
 * @property int|null $pricegroup_update_flg 1: update customer_groupid se update price_policy_id = customer_groupid. price_policy_id
 * @property int|null $membercard_type hang the vang bac ..= point card id
 * @property int|null $total_earn_point
 * @property float|null $total_buy_amount
 * @property float|null $total_remain_amount so tien du chua duoc tich diem dung khi point_setting.fixedmode =0
 * @property string|null $rankcard_start_date
 * @property string|null $cardrank_expire_date
 * @property int|null $status 0: normal  1: đang tich diem
 * @property string|null $password
 * @property string|null $email_password
 * @property string|null $otp_code
 * @property int $otp_verify_flg
 * @property string|null $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereAllowOrderFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereCardrankExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereCustomerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereCustomerSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereEmailPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereExtraInfo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereExtraInfo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereFeeShip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereGroupid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereMembercardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereOtpVerifyFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search wherePricePolicyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search wherePricegroupUpdateFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search wherePriceplan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereRankcardStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereSupplierFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereTotalBuyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereTotalEarnPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereTotalRemainAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_search whereWebsite($value)
 */
	class customer_supplier_search extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\feature_master
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $type 0 : require feature, 1: optional (gói bảo hàng ..) 2: can select  ( mau sac , size)
 * @property string|null $name màu sắc, size
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\feature_master whereType($value)
 */
	class feature_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_extend
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $product_id
 * @property string|null $extend_barcode mã lô, mã vạch riêng mỗi sản phẩm
 * @property string|null $batch_no số lô
 * @property string|null $batch_expire_date ngày hết hạn lô
 * @property string|null $regdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereBatchExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereExtendBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_extend whereShopId($value)
 */
	class product_extend extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\customer_push
 *
 * @property int $id
 * @property int $customer_id
 * @property int $shop_id
 * @property string|null $push_id
 * @property string|null $device_id
 * @property int|null $device_type 0: android; 1: ios
 * @property int|null $app_type 0: ios user
 * @property int|null $is_push
 * @property string|null $build_version
 * @property string|null $device_name
 * @property string|null $os_version
 * @property string|null $langcode
 * @property string|null $regdate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereAppType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereBuildVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereIsPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereLangcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereOsVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push wherePushId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_push whereShopId($value)
 */
	class customer_push extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_search
 *
 * @property int $product_id
 * @property int $shop_id
 * @property int|null $owner_product_id procduct id của sản phẩm gốc
 * @property int|null $owner_shop_id shop id của sản phẩm gốc
 * @property int|null $product_master_id
 * @property string|null $product_master_code
 * @property string|null $product_name
 * @property string|null $product_code
 * @property string|null $product_barcode
 * @property string|null $info1 hoat tinh
 * @property string|null $info2 nuoc san xuat
 * @property string|null $info3 so dang ky
 * @property string|null $info4 quy cach dong goi
 * @property string|null $info5 ham luong
 * @property string|null $info6 hang san xuat
 * @property string|null $short_name
 * @property int|null $available kich hoat
 * @property int|null $receiptflg co ban theo don thuoc
 * @property int|null $product_category_id
 * @property float|null $product_tax thue bán
 * @property int|null $unit_id id đơn vị tính (cái, hộp, ngày , tháng , năm ..)
 * @property string|null $unit_name tên đơn vị
 * @property int|null $product_unit_type 0: minute; 1: hour; 2 day
 * @property int|null $alert_flg 1: alert , 0: ko alert
 * @property float|null $alert_minval cảnh báo dưới mức
 * @property float|null $alert_maxval cảnh báo trên mức
 * @property int|null $service_unit_value thời gian sử dụng dịch vụ theo unit_id
 * @property int|null $service_promotion khuyễn mãi trên dơn vị promotion_unit , mua 1 năm tặng 2 tháng
 * @property int|null $promotion_unit 1: ngay 2 : thang  3: nam
 * @property float|null $product_price giá bán mặc định
 * @property float|null $in_price giá vốn hàng bán
 * @property float|null $buy_price giá mua mặc định
 * @property string|null $product_material đinh lượng nguyên vật liệu
 * @property string|null $combo cấu hình combo hàng hoá
 * @property string|null $eng_name
 * @property int|null $top_flg
 * @property int|null $direct_sell_flg
 * @property int|null $point_get_flg
 * @property int|null $online_sell_flg
 * @property int|null $reseller_flg
 * @property string|null $last_update
 * @property int|null $invalid 1: xóa, 2: ngừng kinh doanh
 * @property string|null $nameSortproduct
 * @property int|null $orderIndexproduct
 * @property int|null $group_price_id
 * @property int|null $product_type 1: hàng hóa, 2: dịch vụ, 3: combo   100: web teamplate 101 : pos service
 * @property int|null $manage_type 0: non serialize 1: serialize
 * @property string|null $serialnum moi item duoc danh mã vạch riêng
 * @property string|null $place_tag json encode table id
 * @property int|null $supplier_id
 * @property string|null $supplier_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereAlertFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereAlertMaxval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereAlertMinval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereBuyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereCombo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereDirectSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereGroupPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInfo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInfo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInfo3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInfo4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInfo5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInfo6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereManageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereNameSortproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereOnlineSellFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereOrderIndexproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereOwnerProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereOwnerShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search wherePlaceTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search wherePointGetFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductMasterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereProductUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search wherePromotionUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereReceiptflg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereResellerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereSerialnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereServicePromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereServiceUnitValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereTopFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_search whereUnitName($value)
 */
	class product_search extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\app_identify
 *
 * @property int $id
 * @property string|null $app_id
 * @property string|null $secret_token
 * @property string|null $callback_url
 * @property string|null $access_token
 * @property int $type 1: user app; 2: web app
 * @property string|null $expire_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereCallbackUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereSecretToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\app_identify whereUpdatedAt($value)
 */
	class app_identify extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\table
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $area_id
 * @property int|null $shop_id
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\table whereUpdatedAt($value)
 */
	class table extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_category
 *
 * @property int $category_id
 * @property int $shop_id
 * @property string|null $category_name nhom hang hoa
 * @property int|null $category_group product type: 0: Dược phẩm; 1: Vật tư y tế; 2: Hàng hóa khác; 3: Hàng hoá; 4: Dịch vụ; 5: Gói dịch vụ; 6: Khác
 * @property int|null $status trang thai 1: available
 * @property string|null $category_desc ghi chu
 * @property string|null $category_small_thumbnail
 * @property int|null $parent_id
 * @property int|null $lang
 * @property int|null $is_default default: 0 shop; 1 system
 * @property int|null $top_flg
 * @property int|null $category_flag
 * @property int|null $manage_flag
 * @property string|null $nameSortcategorys
 * @property string|null $extra_category
 * @property string|null $last_update
 * @property int|null $invalid
 * @property int|null $orderIndexcategorys
 * @property int|null $pricegroup 0: nhom category thuc don  1: nhom category gia normal  2: nhom category gia theo gio 3: nhom category gia theo ngay
 * @property float|null $category_parent_local_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategoryDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategoryFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategoryGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategoryParentLocalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereCategorySmallThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereExtraCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereManageFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereNameSortcategorys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereOrderIndexcategorys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category wherePricegroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_category whereTopFlg($value)
 */
	class product_category extends \Eloquent {}
}

namespace App{
/**
 * App\inventory_detail
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $facility_id id kho hang ref facility_master
 * @property int|null $product_id
 * @property string|null $product_status trang thai don hang
 * @property int $product_extend_id
 * @property string|null $batch_no số lô
 * @property string|null $batch_expire_date ngày hết hạn lô
 * @property float|null $qty_prestock tồn đầu ngày
 * @property float|null $qty_receipt nhập kho
 * @property float|null $qty_return trả hàng
 * @property float|null $qty_stocktake kiem ke kho
 * @property float|null $qty_issues xuat kho
 * @property string|null $note
 * @property string|null $lastupdate
 * @property string|null $regdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereBatchExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereBatchNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereLastupdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereProductExtendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereProductStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereQtyIssues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereQtyPrestock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereQtyReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereQtyReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereQtyStocktake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\inventory_detail whereShopId($value)
 */
	class inventory_detail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\role_permission
 *
 * @property int $id
 * @property int|null $shop_id
 * @property string|null $role_name
 * @property string|null $role_permission
 * @property string|null $note
 * @property string|null $regdate
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereRolePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\role_permission whereShopId($value)
 */
	class role_permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\customer_supplier_group
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $group_name
 * @property string|null $memo
 * @property int|null $invalid
 * @property int|null $price_policy_id
 * @property string|null $usevat set shop.tax
 * @property int|null $payment_method refer asset
 * @property int|null $customer_flg
 * @property int|null $supplier_flg
 * @property string|null $regdate
 * @property int|null $account_flg
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereAccountFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereCustomerFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group wherePricePolicyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereSupplierFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\customer_supplier_group whereUsevat($value)
 */
	class customer_supplier_group extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\product_feature
 *
 * @property int $id
 * @property int $shop_id
 * @property int|null $product_id
 * @property int|null $feature_id fix id thuoc tinh ref property_master
 * @property string|null $feature_name tên thuộc tính : màu sắc, size, số lô ...
 * @property string|null $feature_value color thi xanh, do
 * @property int|null $invalid
 * @property string|null $regdate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereFeatureName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereFeatureValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\product_feature whereShopId($value)
 */
	class product_feature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\unit_master
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $unitname
 * @property int|null $invalid
 * @property int $unit_type 0: all; 1: unit product; 2: unit service
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\unit_master whereUnitname($value)
 */
	class unit_master extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\facility
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $facility_name
 * @property string|null $facility_adress
 * @property string|null $regdate
 * @property int $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility whereFacilityAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility whereFacilityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\facility whereShopId($value)
 */
	class facility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\asset
 *
 * @property int $id
 * @property int|null $shop_id
 * @property string|null $name
 * @property string|null $asset_currency
 * @property float|null $asset_total số tiền chốt quỹ
 * @property int|null $type 0: tk tiền mặt; 1: tk ngân hàng mặc định; 2: tk ngân hàng; 3: tk điểm; 4: tk sử dụng dịch vụ
 * @property string|null $currency_denomination
 * @property int|null $e_wallet_type 0: ko dùng; 1: momo; 2: vnpay
 * @property string|null $e_wallet_info
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $regdate
 * @property string|null $regdate_local
 * @property \Illuminate\Support\Carbon|null $update
 * @property string|null $update_local
 * @property int|null $default_flg
 * @property int|null $invalid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereAssetCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereAssetTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereCurrencyDenomination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereDefaultFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereEWalletInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereEWalletType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereInvalid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereRegdateLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\asset whereUpdateLocal($value)
 */
	class asset extends \Eloquent {}
}

namespace App\SystemModels{
/**
 * App\SystemModels\retail_system
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemModels\retail_system newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemModels\retail_system newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemModels\retail_system query()
 */
	class retail_system extends \Eloquent {}
}

