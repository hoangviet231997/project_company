<?php

namespace App\Http\Controllers\Api\v1;

use App\Helper\Constant;
use App\inventory_detail;
use App\inventory_master;
use App\Models\account;
use App\Models\inventory_transaction_master;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Input;
use Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \App\Helpers\Util;
use Validator;

class InventoryTransactionController extends Controller {
	public function getListInvTransactionMasterByBill(Request $request) {
        if(
            $request->input('date_from') &&
            $request->input('date_to') &&
            $request->input('shop_id') &&
            $request->input('type') &&
            $request->input('sub_type')
        ) {
            $account = new account();
            $inventory_transaction_master = new inventory_transaction_master();
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            $date_to = mb_substr(trim($date_to), 0, 10) . ' 23:59:59';
            $status = $request->input('status');

            if(!$request->input('shop_ids')) {
                $shop_ids = $account->getListShopChild($request->input('shop_id') );
            }
            else {
                $shop_ids = $request->input('shop_ids');
            }
            $type = $request->input('type');
            $sub_type = $request->input('sub_type');
            $search_code = $request->input('search_code');
            $payment_status = $request->input('payment_status');
            $flg_bill_regdate = $request->input('flg_bill_regdate');
            $limit = $request->input('limit') ? $request->input('limit') : Constant::LIMIT_PAGINATION;
            $data = $inventory_transaction_master->getListInvTransactionMasterByBill(
                $date_from,
                $date_to,
                $status,
                $shop_ids,
                $type,
                $sub_type,
                $search_code,
                $payment_status,
                $flg_bill_regdate,
                $limit
            );
            if(count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function getListInvTransactionMasterByProduct(Request $request)
    {
        if (
            $request->input('shop_id') &&
            $request->input('date_from') &&
            $request->input('date_to') &&
            $request->input('product_id') &&
            $request->input('type') &&
            $request->input('sub_type')
        ) {
            $account = new account();
            $inventory_transaction_master = new inventory_transaction_master();
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            $date_to = mb_substr(trim($date_to), 0, 10) . ' 23:59:59';

            if (!$request->input('shop_ids')) { // array
                $shop_ids = $account->getListShopChild($request->input('shop_id'));
            } else {
                $shop_ids = $request->input('shop_ids');
            }
            $status = $request->input('status');
            $product_id = $request->input('product_id');
            $type = $request->input('type');
            $sub_type = $request->input('sub_type');
            $payment_status = $request->input('payment_status');
            $flg_bill_regdate = $request->input('flg_bill_regdate');
            $limit = $request->input('limit') ? $request->input('limit') : Constant::LIMIT_PAGINATION;

            $data = $inventory_transaction_master->getListInventoryMasterByProduct(
                $date_from,
                $date_to,
                $status,
                $shop_ids,
                $type,
                $sub_type,
                $product_id,
                $payment_status,
                $flg_bill_regdate,
                $limit
            );
            if (count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        } else {
            return $this->respondMissingParam();
        }
    }

    public function getListHistoryBillForProduct(Request $request)
    {
        if ($request->input('shop_id') && $request->input('product_id')) {
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');

            if ($date_from == null) {
                $date_from = date("Y-m-01", strtotime(Carbon::now()));
            }
            if ($date_to == null) {
                $date_to = date("Y-m-t", strtotime(Carbon::now()));
            }
            if (strlen($date_to) <= 10) {
                $date_to .= " 23:59:59";
            }

            $batch_id = $request->input('batch_id');
            $product_id = $request->input('product_id');
            $type = $request->input('type');
            $sub_type = $request->input('sub_type');
            $limit = $request->input('limit') ?? Constant::LIMIT_PAGINATION;
            $inventory_transaction_master = new inventory_transaction_master();
            $data = $inventory_transaction_master->getListHistoryBillForProduct($date_from, $date_to, $type,
                    $sub_type, $product_id, $batch_id, $limit);
            if (count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        } else {
            return $this->respondMissingParam();
        }
    }

    public function getInventoryTransactionDetail(Request $request){
        if($request->input('shop_id') && $request->input('transaction_masterid')){
            $req = Input::all();
            $data = inventory_transaction_master::getInventoryTransactionDetail($req);
            if(count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function getListInventoryDetail(Request $request){
        if ($request->input('shop_id')){
            $account = new account();
            $inventory_transaction_master = new inventory_transaction_master();
            $data['product_type'] = $request->input('product_type');
            $data['key_search'] = $request->input('key_search');
            $data['product_category'] = $request->input('product_category');
            $data['stock_quantity'] = $request->input('stock_quantity');
            $data['batch_expire_date'] = $request->input('batch_expire_date');
            $data['status'] = $request->input('status');
            $data['limit'] = $request->input('limit') ? $request->input('limit') : Constant::LIMIT_PAGINATION;
            $data['date_from'] = $request->input('date_from');
            $data['date_to'] = $request->input('date_to');

            if ($data['date_from'] == null) {
                $data['date_from'] = date("Y-m-01 00:00:01", time());
            }
            else {
                $data['date_from'] = mb_substr($data['date_from'], 0, 10) . ' 00:00:01';
                $data['date_to'] = mb_substr($data['date_to'], 0, 10) . ' 23:59:59';
            }


            if ($data['date_to'] == null) {
                $data['date_to'] = date("Y-m-t 23:59:59", time());
            }
            else if (strlen($data['date_to']) <= 10) {
                $data['date_to'] .= " 23:59:59";
            }

            if (!$request->input('shop_ids')) {
                $data['shop_ids'] = $account->getListShopChild($request->input('shop_id'));
            } else {
                $data['shop_ids'] = $request->input('shop_ids');
            }

            $data['now'] = Carbon::now();
            $day = Constant::LIMIT_BATCH_EXPIRE_DATE;
            $data['expire_date'] = $data['now']->addDays($day);

            $data = $inventory_transaction_master->getListInventoryDetail($data);
            if(count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function createBillInventoryTransaction(Request $request) {
        $data['dateCreated'] = $request->input('date_create');
        $data['account_id'] = $request->input('account_id');
        $data['account_name'] = $request->input('account_name');
        $data['shop_id'] = $request->input('shop_id');
        $data['facility_id'] = $request->input('facility_id');
        $data['total'] = $request->input('total');
        $data['type'] = $request->input('type');
        $data['sub_type'] = $request->input('sub_type');
        $data['transaction_with_name'] = $request->input('transaction_with_name');
        $data['transaction_with_id'] = $request->input('transaction_with_id');
        $data['bill_regdate'] = strtotime($request->input('bill_regdate')) ? $request->input('bill_regdate') : Util::getNow();
        $data['note'] = $request->input('note');
        $data['paidTotal'] = $request->input('paid_total');
        $data['status'] = 0;
        $data['id'] = Util::getLocalId($data['shop_id']);//$request->input('local_id');
        $data['version_code'] = 1;
        $data['master_local_regdate'] = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
        $data['itm_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $debt_total = $request->input('debt_total');
        $data_product = $request->input('product');
        $code = $request->input('code');

        if(!isset(Constant::$field_require_transaction[$data['sub_type']]) && ($data['type'] != 3)) {
            return $this->respondMissingParam();
        }
        if ($data['type'] != 3) {
            foreach (Constant::$field_require_transaction[$data['sub_type']] as $field) {
                if (!isset($data[$field])) {
                    return $this->respondMissingParam();
                }
            }
            if ($debt_total && $data['paidTotal']) {
                $data['payment_status'] = 2;
            } else {
                if ($data['paidTotal'] && !$debt_total) {
                    $data['payment_status'] = 1;
                } else {
                    $data['payment_status'] = 3;
                }
            }
        }
        else {
            foreach (Constant::$field_required_transaction_check_stock as $field) {
                if (!isset($data[$field])) {
                    return $this->respondMissingParam();
                }
            }
            $data['payment_status'] = 1;

        }

        if(!$data_product || !is_array($data_product)) {
            return $this->respondMissingParam();
        }

        $check_local_id = inventory_transaction_master::checkLocalIdTransaction($data['id']);

        if($check_local_id) {
            return $this->respondError(__('messages.exists_local_id'));
        }

        $result = inventory_transaction_master::createInventoryTransaction($data, $data_product, $code);

        if(isset($result['msg_error'])) {
            return $this->respondError($result['msg_error']);
        }
        else {
            return $this->respondSuccess($result['msg_success']);
        }
    }

    public function importExcelTransaction(Request $request) {
        $data['dateCreated'] = $request->input('date_create');
        $data['account_id'] = $request->input('account_id');
        $data['account_name'] = $request->input('account_name');
        $data['shop_id'] = $request->input('shop_id');
        $data['facility_id'] = $request->input('facility_id');
        $data['total'] = $request->input('total');
        $data['type'] = $request->input('type');
        $data['sub_type'] = $request->input('sub_type');
        $data['transaction_with_name'] = $request->input('transaction_with_name');
        $data['transaction_with_id'] = $request->input('transaction_with_id');
        $data['bill_regdate'] = strtotime($request->input('bill_regdate')) ? $request->input('bill_regdate') : Util::getNow();
        $data['note'] = $request->input('note');
        $data['paidTotal'] = $request->input('paid_total');
        $data['status'] = 0;
        $data['id'] = Util::getLocalId($data['shop_id']);//$request->input('local_id');
        $data['version_code'] = 1;
        $data['master_local_regdate'] = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
        $data['itm_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $debt_total = $request->input('debt_total');
        $data_product = $request->input('product');
        $code = $request->input('code');


        if(!isset(Constant::$field_require_transaction[$data['sub_type']]) && ($data['type'] != 3)) {
            return $this->respondMissingParam();
        }
        if ($data['type'] != 3) {
            foreach (Constant::$field_require_transaction[$data['sub_type']] as $field) {
                if (!isset($data[$field])) {
                    return $this->respondMissingParam();
                }
            }
            if ($debt_total && $data['paidTotal']) {
                $data['payment_status'] = 2;
            } else {
                if ($data['paidTotal'] && !$debt_total) {
                    $data['payment_status'] = 1;
                } else {
                    $data['payment_status'] = 3;
                }
            }
        }
        else {
            foreach (Constant::$field_required_transaction_check_stock as $field) {
                if (!isset($data[$field])) {
                    return $this->respondMissingParam();
                }
            }
            $data['payment_status'] = 1;

        }

        if(!$data_product || !is_array($data_product)) {
            return $this->respondMissingParam();
        }

        $check_local_id = inventory_transaction_master::checkLocalIdTransaction($data['id']);

        if($check_local_id) {
            return $this->respondError(__('messages.exists_local_id'));
        }

        $result = inventory_transaction_master::createInventoryTransactionExcel($data, $data_product, $code);

        if(isset($result['msg_error'])) {
            return $this->respondError($result['msg_error']);
        }
        else {
            return $this->respondSuccess($result['msg_success']);
        }
    }

    public function editBillTransaction(Request $request) {
        $data['id'] = $request->input('transaction_id');
        $shop_id = $request->input('shop_id');
        $data['shop_id'] = $shop_id;
        $data['dateCreated'] = $request->input('date_create');
        $data['account_id'] = $request->input('account_id');
        $data['account_name'] = $request->input('account_name');
        $data['facility_id'] = $request->input('facility_id');
        $data['total'] = $request->input('total');
        $data['transaction_with_name'] = $request->input('transaction_with_name');
        $data['transaction_with_id'] = $request->input('transaction_with_id');
        $data['bill_regdate'] = $request->input('bill_regdate');
        $data['note'] = $request->input('note');
        $data['paidTotal'] = $request->input('paid_total');
        $data['master_local_regdate'] = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
        $data['itm_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['type'] = $request->input('type');
        $data['sub_type'] = $request->input('sub_type');
        $data['code'] = $request->input('code');
        $update = $request->input('last_update') ?? Carbon::now()->format('Y-m-d H:i:s');
        $debt_total = $request->input('debt_total');
        $data_product = $request->input('product');

        if(
            (($data['type'] != 3) &&
            !isset(Constant::$field_require_transaction[$data['sub_type']])) ||
            !$data_product ||
            !is_array($data_product)
        ) {
            return $this->respondMissingParam();
        }

        if ($data['type'] != 3) {
            foreach (Constant::$field_require_transaction[$data['sub_type']] as $field) {
                if (!isset($data[$field])) {
                    return $this->respondMissingParam();
                }
            }
            if ($debt_total && $data['paidTotal']) {
                $data['payment_status'] = 2;
            } else {
                if ($data['paidTotal'] && !$debt_total) {
                    $data['payment_status'] = 1;
                } else {
                    $data['payment_status'] = 3;
                }
            }
        }
        else {
            foreach (Constant::$field_required_transaction_check_stock as $field) {
                if (!isset($data[$field])) {
                    return $this->respondMissingParam();
                }
            }
            $data['payment_status'] = 1;
        }

        $edit_transaction = inventory_transaction_master::editTransaction(
            $data['id'],
            $data,
            $data_product,
            $shop_id,
            $update
        );

        if(isset($edit_transaction['msg_error'])) {
            return $this->respondError($edit_transaction['msg_error']);
        }
        else {
            return $this->respondSuccess('', __('messages.success'));
        }
    }

    public function cancelBillTransaction(Request $request) {
        $shop_id = $request->input('shop_id');
        $transaction_id = $request->input('transaction_id');
        $account_id = $request->input('account_id');
        $account_name = $request->input('account_name');

        if($transaction_id && $account_id && $account_name) {

            $cancel = inventory_transaction_master::cancelTransaction(
                $shop_id,
                $transaction_id,
                $request
            );

            if(isset($cancel['msg_error'])) {
                return $this->respondError($cancel['msg_error']);
            }
            else {
                return $this->respondSuccess(null, $cancel['msg_success']);
            }
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function createBillProvidedReceive(Request $request) {
        $data['shop_id'] = $request->input('shop_id');
        $data['id'] = Util::getLocalId($data['shop_id']); //$request->input('local_id');
        $data['account_id'] = $request->input('account_id');
        $data['account_name'] = $request->input('account_name');
        $data['dateCreated'] = $request->input('date_create');
        $data['bill_regdate'] = $request->input('date_create');
        $data['total'] = $request->input('total');
        $data['paidTotal'] = $request->input('total');
        $data['itm_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['master_local_regdate'] = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
        $data['payment_status'] = 1;
        $data['version_code'] = 1;
        $data['note'] = $request->input('note');
        $data['status'] = 1; //tam
        $data['type'] = 4;
        $data_product = $request->input('product');
        $shop_id_provided = $request->input('shop_id_provided');
        $shop_id_receive = $request->input('shop_id_receive');
        $facility_id_provided = $request->input('facility_id_provided');
        $facility_id_receive = $request->input('facility_id_receive');
        $code = $request->input('code');

        foreach (Constant::$field_required_transaction_provided_receive as $field) {
            if(!isset($data[$field])) {
                return $this->respondMissingParam();
            }
        }

        if(!$shop_id_provided || !$shop_id_receive || !$facility_id_provided || !$facility_id_receive) {
            return $this->respondMissingParam();
        }

        $data_provided = $data;
        $data_provided['shop_id'] = $shop_id_provided;
        $data_provided['facility_id'] = $facility_id_provided;
        $data_provided['type'] = 2;
        $data_provided['sub_type'] = 4;
        $data_provided['itm_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $data_provided['master_local_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['shop_id_provided'] = $shop_id_provided;
        $data['shop_id_receive'] = $shop_id_receive;
        $data['facility_id'] = $facility_id_provided;
        $data['facility_id_receive'] = $facility_id_receive;

        $check_local_id = inventory_transaction_master::checkLocalIdTransaction($data['id']);

        if($check_local_id) {
            return $this->respondError(__('messages.exists_local_id'));
        }

        $result_provided = inventory_transaction_master::createInventoryTransaction($data_provided, $data_product, $code, $data);

        if(isset($result_provided['msg_error'])) {
            return $this->respondError($result_provided['msg_error']);
        }
        else {
            return $this->respondSuccess(__('messages.success'));
        }
    }

    public function editBillProvidedReceive(Request $request) {
        $shop_id = $request->input('shop_id');
        $id = $request->input('transaction_id');
        $data['account_id'] = $request->input('account_id');
        $data['account_name'] = $request->input('account_name');
        $data['dateCreated'] = $request->input('date_create');
        $data['bill_regdate'] = $request->input('date_create');
        $data['total'] = $request->input('total');
        $data['paidTotal'] = $request->input('total');
        $data['itm_regdate'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['master_local_regdate'] = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
        $data['payment_status'] = 1;
        $data['version_code'] = 1;
        $data['note'] = $request->input('note');
        $data['status'] = 1; //temp
        $data['type'] = 4;
        $data['payment_status'] = 1;
        $data['code'] = $request->input('code');
        $data_product = $request->input('product');
        $shop_id_provided = $request->input('shop_id_provided');
        $shop_id_receive = $request->input('shop_id_receive');
        $facility_id_provided = $request->input('facility_id_provided');
        $facility_id_receive = $request->input('facility_id_receive');
        $update = $request->input('last_update') ?? Carbon::now()->format('Y-m-d H:i:s');


        foreach (Constant::$field_required_transaction_provided_receive as $field) {
            if (!isset($data[$field])) {
                return $this->respondMissingParam();
            }
        }

        $data_provided = $data;
        $data_provided['shop_id'] = $shop_id_provided;
        $data_provided['facility_id'] = $facility_id_provided;
        $data_provided['type'] = 2;
        $data_provided['sub_type'] = 4;
        $data_provided['last_update'] = $update;
        $data['shop_id_provided'] = $shop_id_provided;
        $data['shop_id_receive'] = $shop_id_receive;
        $data['facility_id'] = $facility_id_provided;
        $data['facility_id_receive'] = $facility_id_receive;

        $edit_transaction = inventory_transaction_master::editTransactionProvided(
            $id,
            $data,
            $data_provided,
            $data_product,
            $shop_id
        );

        if(isset($edit_transaction['msg_error'])) {
            return $this->respondError($edit_transaction['msg_error']);
        }
        else {
            return $this->respondSuccess('', __('messages.success'));
        }
    }

    public function verifyBillProvidedReceive(Request $request) {
        $shop_id = $request->input('shop_id');
        $transaction_id = $request->input('transaction_id');
        $account_id = $request->input('account_id');
        $account_name = $request->input('account_name');
        $verify_flg = $request->input('verify_flg');   //1 accept, 0 cancel
        $regdate = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
        $note = $request->input('note');
        if($shop_id && $transaction_id) {
            $verify = inventory_transaction_master::verifyBillProvidedReceive(
                $shop_id,
                $transaction_id,
                $account_id,
                $account_name,
                $verify_flg,
                $regdate,
                $note
            );

            if(isset($verify['msg_error'])) {
                return $this->respondError($verify['msg_error']);
            }
            else {
                return $this->respondSuccess(null, __('messages.success'));
            }
        }
        else {
            return $this->respondMissingParam();
        }
    }


    public function getListInventoryTransactionMaster(Request $request)
    {
        if (
            $request->input('date_from') &&
            $request->input('date_to')
        ) {
            $account = new account();
            $inventory_transaction_master = new inventory_transaction_master();
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            if (strlen($date_to) <= 10) {
                $date_to .= " 23:59:59";
            }
            $status = $request->input('status');
            $type = $request->input('type');
            $sub_type = 4;
            if (!$request->input('shop_ids')) {
                $shop_ids = $account->getListShopChild($request->input('shop_id'));
            } else {
                $shop_ids = $request->input('shop_ids');
            }
            $search_key = $request->input('search_key');
            $search_product_id = $request->input('search_product_id');
            if($search_product_id != null){
                $search_key = null;
            }
            $limit = $request->input('limit') ?? Constant::LIMIT_PAGINATION;
            $data = $inventory_transaction_master->getListInventoryTransactionMaster(
                $date_from,
                $date_to,
                $status,
                $type,
                $sub_type,
                $shop_ids,
                $search_key,
                $limit,
                $search_product_id
            );
            if (count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        } else {
            return $this->respondMissingParam();
        }
    }


    public function getAllInventoryMaster(Request $request) {
        $shop_id = $request->input('shop_id');
        $data = inventory_master::getAllInventoryMaster($shop_id);

        return $this->respondSuccess($data, __('messages.success'));
    }
}
