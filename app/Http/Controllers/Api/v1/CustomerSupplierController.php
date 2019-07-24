<?php

namespace App\Http\Controllers\Api\v1;

use App\Exports\CustomerAgencyExport;
use App\Exports\CustomerSupplier;
use App\Helper\Constant;
use App\Imports\CustomersImport;
use Validator;
use App\Models\customer_supplier;
use App\Models\role_permission;
use App\Models\shop;
use Session;
use Illuminate\Http\Request;
use App\Helpers\Util;
use App\Models\customer_push;
use Illuminate\Support\Facades\File;

class CustomerSupplierController extends Controller {
	public function getListSupplier(Request $request){
        if(isset($request->status)){
            $shop_id = $request->input('shop_id');
            $status = $request->input('status', 1);
            $data = customer_supplier::getListSupplier($shop_id, $request->name, $status);
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function getListCustomer(Request $request){
        if(isset($request->status)){
            $shop_id = $request->input('shop_id');
            $status = $request->input('status', 1);
            $data = customer_supplier::getListCustomer($shop_id, $request->name, $status);
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateOrInsertCustomerSupplier(Request $request, $is_customer = null){
        if($request['name']) {
            $is_customer ? $request['customer_flg'] = 1  : $request['supplier_flg'] = 1;
            $request['regdate'] = Util::getNow();
            $id = $request['id'] ? $request ['id'] : null;

            $data = $request->except('token');

            $response = customer_supplier::updateOrInsertCustomerSupplier($data, $id);
            if($response){
                if(gettype($response) == 'boolean'){
                    return $this->respondSuccess();
                }
                else{
                    return $this->respondSuccess($response);
                }
            }
            else{
                return $this->respondFail();
            }
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function deleteCustomerSupplier(Request $request){
        $id = $request->input('id');
        $shop_id = $request->input('shop_id');
        if($id) {
            $delete = customer_supplier::deleteCustomerSupplier($id, $shop_id);
            if($delete) {
                return $this->respondSuccess(null, __('messages.success'));
            }
            else {
                return $this->respondSuccess(null, __('messages.fail'));
            }
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function getCustomerSupplierDetail(Request $request) {
    	if($request->id) {
			$data = customer_supplier::getCustomerSupplierById($request->id, $request->shop_id);

    		return $this->respondSuccess($data);
		}
		else {
			return $this->respondMissingParam();
		}
    }

    public function registerNewCustomer(Request $request){
        if($request['tel'] && $request['name'] && $request['password'])
        {
            $request['customer_flg'] = 1;
            $request['regdate'] = Util::getNow();
            $data = $request->except(['push_id', 'device_id', 'device_type']);
            if(isset($request['push_id']) && isset($request['device_id']) && isset($request['device_type'])){
                $query = customer_supplier::insertNewCustomer($data, $request['push_id'], $request['device_id'], $request['device_type']);
            }
            else{
                $query = customer_supplier::insertNewCustomer($data);
            }

            if(is_array($query)){
                return $this->respondSuccess($query);
            }
            else if($query == 1) {
                return $this->respondError(__('messages.error'));
            }
            else if($query == 2) {
				return $this->respondError(__('messages.existed_account'));
			}
        }
        else
        {
            return $this->respondMissingParam();
        }
    }

    public function updateInfo(Request $request){
        $data = $request->except(['image']);
        $query = customer_supplier::updateCustomer($data, $request->image);
        if(is_array($query)){
            return $this->respondSuccess($query);
        }
        else if ($query == 2){
            return $this->respondError(__('messages.existed_data'));
        }
        return $this->respondError();
    }

    public function verifyOtp(Request $request){
        if($request['otp_code'])
        {
            $data = $request->all();
            $query = customer_supplier::verifyOtp($data);

            if($query){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError();
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function resendOtp(Request $request){
        $data = $request->all();
        $query = customer_supplier::resendOtp($data);

        if($query){
            return $this->respondSuccess($query);
        }
        else{
            return $this->respondError();
        }
    }

    public function login(Request $request){
        if($request['tel'] && $request['password']){
            $data = $request->all();
            $query = customer_supplier::login($data);

            if($query){
                return $this->respondSuccess($query);
            }
            else{
                return $this->respondError();
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function sendSms(Request $request){
        $data= $request->all();
        $query = customer_supplier::sendOtpSms($data);
        if($query){
            return $this->respondSuccess();
        }
        else{
            return $this->respondError();
        }
    }

    public function logout(Request $request){
        if($request->device_id){
            //$data= $request->all();
            $customer_id = customer_supplier::where('token', $request['token'])->first()->id;
            $query = customer_push::deleteCustomerPushByDeviceIdAndCustomerId($customer_id, $request->device_id, $request->app_type);
            if($query){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError();
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function forgotPassword(Request $request){
        if($request->email){
            $response = customer_supplier::forgotPassword($request->email);
            if($response == 'messages.success') {
                return $this->respondSuccess();
            }
            return $this->respondError(__($response));
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updatePasswordByEmail(Request $request){
        if($request->email && $request->email_password && $request->new_password){
            $response = customer_supplier::updatePasswordByEmail($request->email, $request->email_password, $request->new_password);
            if($response == 'messages.success') {
                return $this->respondSuccess();
            }
            return $this->respondError(__($response));
        }
        return $this->respondMissingParam();
    }

    public function exportListCustomer(Request $request) {
        $shop_id = $request->input('shop_id');
        $customer_name = $request->input('customer_name');
        $status = $request->input('status');
        $customer_flg = $request->input('customer_flg') ?? 0;
        $file_name = "customer_{$shop_id}.xls";
        if(File::exists(public_path("export_customer/{$file_name}"))) {
            File::delete(public_path("export_customer/$file_name"));
        }
        (new CustomerSupplier($shop_id, $customer_name, $status, $customer_flg))->store($file_name,  'export_customer');
        $data = [ 'link' => $_SERVER['APP_URL'] . "/export_customer/{$file_name}"];

        return $this->respond($data);
    }

    public function importCustomerExcel(Request $request) {
		if($customer_import_file = $request->file('customer_import')) {
			$file_name = Util::getUploadFileName($customer_import_file->getClientOriginalExtension(), $request->shop_id);
			$customer_import_file->move(storage_path('import_excel_transaction'), $file_name);
			$customers = (new CustomersImport)->toArray($file_name, 'import_excel_transaction')[0];
			$response = customer_supplier::exportCustomerExcelTransaction($customers);
			return $this->respondSuccess($response);
		}
		else {
			return $this->respondError();
		}
	}

	public function importCustomers(Request $request) {
		if($customers = $request->customers) {
			customer_supplier::importCustomers($customers, $request->shop_id);
			return $this->respondSuccess();
		}
		else {
			return $this->respondError();
		}
	}

	public function createOrUpdateCustomerAgency(Request $request) {
	    $shop_id = $request->input('shop_id');
	    $data = $request->all();
	    $response = customer_supplier::createOrUpdateCustomerAgency($shop_id, $data);

	    if(!is_object($response)) {
	        return $this->respondError($response);
        }

	    return $this->respondSuccess($response);
    }


    public function registerCustomerAgency(Request $request){
        if( !$request->name || !$request->username || !$request->password ){
            return $this->respondMissingParam();
        }
        $shop_id = shop::getShopParentAgency();
        $data = $request->all();
        $get_role_permission = role_permission::getDefaultRoleInformation($shop_id)->first();
        if($get_role_permission == 'messages.error') {
            return $this->respondError(__('messages.role_default_not_found'));
        }
        $data['role_permission'] = $get_role_permission->role_id;
        $data['id'] = $data['shop_id_create'] = $data['groupid'] = null;
        $data['shop_id'] = $shop_id;
        $data['available'] = 1;
        $response = customer_supplier::createOrUpdateCustomerAgency($shop_id, $data);
        if(is_object($response)) {
            return $this->respondSuccess($response);
        }
        return $this->respondError($response);
    }

    public function getCustomerAgencyDetail(Request $request) {
	    $shop_id = $request->input('shop_id');
	    $id = $request->input('id');
	    $data = customer_supplier::getCustomerAgencyDetail($id, $shop_id);
	    return $this->respondSuccess($data);
    }

    public function getListCustomerAgency(Request $request) {
	    $shop_id = $request->input('shop_id');
        $status = $request->input('status');
        $name = $request->input('name');

        $data = customer_supplier::getListCustomerAgencyDetail($shop_id, $status, $name);

        return $this->respondSuccess($data);
    }

    public function exportListCustomerAgency(Request $request) {
        $shop_id = $request->input('shop_id');
        $name = $request->input('name');
        $status = $request->input('status');
        $file_name = "customer_agency_{$shop_id}.xls";
        if(File::exists(public_path("export_customer/{$file_name}"))) {
            File::delete(public_path("export_customer/$file_name"));
        }
        (new CustomerAgencyExport($shop_id, $name, $status))->store($file_name,  'export_customer');
        $data = [ 'link' => $_SERVER['APP_URL'] . "/export_customer/{$file_name}"];

        return $this->respond($data);
    }

    public function deleteCustomerAgency(Request $request) {
	    $shop_id = $request->input('shop_id');
	    $id = $request->input('id');
	    $account_id = $request->input('account_id');

	    $delete = customer_supplier::deleteCustomerAgency($shop_id, $id, $account_id);
	    if($delete) {
	        return $this->respondSuccess();
        }
        else {
            return $this->respondError();
        }
    }

    public function getListShopAgency(Request $request) {
	    $shop_id = $request->input('shop_id');
	    $data = customer_supplier::getListShopAgency($shop_id);
	    return $this->respondSuccess($data);
    }

    public function getListShopAgencyName(Request $request) {
	    $shop_id = $request->input('shop_id');
	    $data = customer_supplier::getListShopAgencyName($shop_id);
	    return $this->respondSuccess($data);
    }
}
