<?php

namespace App\Models;

use App\Helper\Constant;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lang;

class customer_supplier extends Model
{
    protected $table = 'customer_supplier';
    protected $fillable = [
        'shop_id',
        'name',
		'customer_flg',
		'supplier_flg',
        'groupid',
        'address',
        'tel',
        'notes',
        'email',
        'website',
        'tax_code',
        'status',
        'invalid',
    ];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [
            "name" => 'required|max:255',
            "groupid" => 'integer|nullable',
            "address" => 'max:255',
            "tel" => 'max:255',
            "notes" => 'max:500',
            "email" => 'max:255',
            "website" => 'max:255',
            "tax_code" => 'required|max:255',
            "status" => 'boolean',
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public function findById($id) {
        return $this->select(
            'id',
            'name',
            'groupid',
            'address',
            'tel',
            'notes',
            'email',
            'website',
            'tax_code',
            'status')
            ->where('id',$id)
            ->where('invalid',0) // Check deleted
            ->first();
    }

    public function invalidById($id) {
        return $this->where('id',$id)->update(['invalid' => 1]);
    }

    public static function getListSupplier($shop_id, $name, $status) {
        $query = customer_supplier::select([
            'customer_supplier.*',
            DB::Raw('customer_supplier_group.group_name as group_name')
        ])
        ->leftJoin('customer_supplier_group', function($join){
            $join->on('customer_supplier_group.id', '=', 'customer_supplier.groupid');
        })
        ->where(['customer_supplier.shop_id' => $shop_id,
        'customer_supplier.invalid' => 0,
        'customer_supplier.supplier_flg' => 1
        ]);//->select('id','name')

        if(!is_null($name)) {
			$query->where('customer_supplier.name', 'like', "%$name%");
		}

		if(!is_null($status)) {
			$query->where('customer_supplier.status', $status);
        }

        $query = $query->get();

        return $query->makeHidden('customer_supplier.invalid');
    }

    public static function getListCustomer($shop_id, $name, $status){
        $query = customer_supplier::select([
            'customer_supplier.*',
            DB::Raw('customer_supplier_group.group_name as group_name')
        ])
        ->leftJoin('customer_supplier_group', function($join){
            $join->on('customer_supplier_group.id', '=', 'customer_supplier.groupid');
        })
        ->where(['customer_supplier.shop_id' => $shop_id,
        'customer_supplier.invalid' => 0,
        'customer_supplier.customer_flg' => 1
        ]);//->select('id','name')

        if(!is_null($name)) {
			$query->where('customer_supplier.name', 'like', "%$name%");
		}

		if(!is_null($status)) {
			$query->where('customer_supplier.status', $status);
        }

        $query = $query->get();

        return $query->makeHidden('customer_supplier.invalid');
    }

    public static function updateOrInsertCustomerSupplier($data, $id = null){
        if(is_null($id)){
            $last_id = customer_supplier::insertGetId($data);
            if($last_id){
                $response = customer_supplier::where('id', $last_id)->first();
                return $response;
            }
        }
        else{
            $query = customer_supplier::updateOrInsert(['id' => $id], $data);
            if($query){
                return true;
            }
        }
        return false;
    }

    public static function deleteCustomerSupplier($id, $shop_id){
        $delete = customer_supplier::where([
            'id' => $id,
            'invalid' => 0,
            'shop_id' => $shop_id,
        ])->update(['invalid' => 1]);
        return $delete;
    }

    public static function getOrderCountByCustomerId($customer_id, $shop_id) {
    	return customer_supplier::where([
    		'id' => $customer_id,
			'shop_id' => $shop_id,
		])->pluck('order_count');
	}

	public static function updateOrderCountById($customer_id, $plus = true, $count = 1, $shop_id) {
		$operator = $plus === true ? '+' : '-';

		$sql = <<<EOD
update customer_supplier
set order_count = order_count {$operator} {$count}
where id = '{$customer_id}' and shop_id = '{$shop_id}'
EOD;
		DB::update($sql);
	}

	public static function getCustomerSupplierById($id, $shop_id) {
		return customer_supplier::where([
			'id' => $id,
			'shop_id' => $shop_id,
		])->first();
    }

    public static function countTelExisted($tel, $id){
        $query = customer_supplier::where([
            'tel' => $tel,
            'invalid' => 0
        ]);
        if(!is_null($id)){
            $query->where('id', '<>', $id);
        }
		return $query->count();
	}

    public static function insertNewCustomer($data, $push_id=null, $device_id=null, $device_type=null, $id = null)
    {
        if(customer_supplier::countTelExisted($data['tel'], $id) == 0)
        {
            $data['password'] = sha1($data['password']);
            $data['token'] = Util::getToken();
            $data['otp_code'] = Util::generateOTP();

            if($last_id = customer_supplier::insertGetId($data))
            {
                if($last_id != false)
                {
                    $image_url = '';
                    if(isset($data['image'])){

                        $image_extension = $data['image']->getClientOriginalExtension();
                        $image_name = $last_id.'.'.$image_extension;
                        $do_upload = Util::uploadImage($data['image'], '/upload/customer/', $image_name);
                        if(!$do_upload){
                            return 0;
                        }
                        else{
                            $image_url = 'http://'.$_SERVER['HTTP_HOST'].'/upload/customer/'.$image_name;
                            customer_supplier::where('id', $last_id)->update(['image' => $image_url]);
                        }
                    }

                    if(!is_null($push_id) && !is_null($device_id) && !is_null($device_type))
                    {
                        customer_push::deleteCustomerPushByDeviceId($device_id);
                        $push_data['push_id'] = $push_id;
                        $push_data['device_id'] = $device_id;
                        $push_data['device_type'] = $device_type;
                        $push_data['customer_id'] = $last_id;
                        customer_push::updateOrInsert($push_data);
                    }
                    $response = array('otp_code' => $data['otp_code'], 'token' => $data['token'], 'image' => $image_url);

                    $sms_content =  "Mã OTP của bạn là: {$data['otp_code']}";
                    Util::sendSMS($data['tel'], $sms_content);

                    return $response;
                }
                else
                {
                    return 1;
                }
            }

        }
        else
        {
            return 2;
        }
    }

    public static function validateUserToken($token) {
        if($token){
            $countData = customer_supplier::where('token', $token)->count();
            if($countData > 0){
                return true;
            }
            else{
                return false;
            }

        }
        return false;
	}

    public static function verifyOtp($data){
        $query = customer_supplier::where([
            'token' => $data['token'],
            'otp_code' => $data['otp_code']
            ]);

        $checkOtp = $query->count();
        if($checkOtp > 0){
            if($query->update(['otp_verify_flg' => 1])){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function resendOtp($data){
        $otp_code = Util::generateOTP();
        $query = customer_supplier::where('token', $data['token'])
                        ->update(['otp_code' => $otp_code]);
        if($query){
            return array('otp_code' => $otp_code);
        }
        else{
            return false;
        }
    }

    public static function login($data){
        $data['password'] = sha1($data['password']);
        $query = customer_supplier::where([
            'tel' => $data['tel'],
            'password' => $data['password'],
            'otp_verify_flg' => 1
        ]);
        $check_count = $query->count();
        if($check_count > 0){
            $response_data = $query->first()->makeHidden('password');
            return $response_data;
        }
        else{
            return false;
        }

    }

    public static function sendOtpSms($data){
        $query = customer_supplier::where([
            'token' => $data['token']
        ])->first();

        if($query){
            $tel = $query->tel;
            $otp_code = $query->otp_code;
//            $content = "Thanh cong Ma OTP ". $otp_code;
            $content = "Thành công Mã OTP ". $otp_code;
            $response = Util::sendSMS($tel, $content);
            if($response){
                return $response;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

    }

    public static function updateCustomer($data, $image = null){
        $data['image'] = "";
        $data['regdate'] = Util::getNow();
        $data['id'] = customer_supplier::where('token', $data['token'])->first()->id;
        if(isset($data['tel'])){
            if(customer_supplier::countTelExisted($data['tel'], $data['id']) > 0){
                return 2;
            }
        }
        if(isset($data['password'])){
            $data['password'] = sha1($data['password']);
        }
        if($image && $image->getClientOriginalExtension()){
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $data['id'].'.'.$image_extension;
            $do_upload = Util::uploadImage($image, '/upload/customer/', $image_name);
            if(!$do_upload){
                return 0;
            }
            else{
                $data['image'] = 'http://'.$_SERVER['HTTP_HOST'].'/upload/customer/'.$image_name;
            }
        }
        else {
            $data['image'] = customer_supplier::where('token', $data['token'])->first()->image;
        }

        $query = customer_supplier::updateOrInsert(['token' => $data['token']], $data);
        if(!$query){
            return 0;
        }
        $response = array('image' => $data['image']);
        return $response;
    }

    public static function deleteCustomerSupplierByGroupId($shop_id, $groupid){
        $query = customer_supplier::where([
            'shop_id' => $shop_id,
            'groupid' => $groupid,
            'invalid' => 0
        ]);
        if($query->count() > 0){
            if(!$query->update(['invalid' => 1])){
                return false;
            }
        }
        return true;
    }

    public static function countEmailExisted($email){
        $query = customer_supplier::where([
            'email' => $email,
            'invalid' => 0
        ]);
		return $query->count();
    }

    public static function checkValidEmailPassword($email, $email_password){
        $query = customer_supplier::where([
            'email' => $email,
            'invalid' => 0,
            'email_password' => $email_password
        ]);
		return $query->count();
    }

    public static function forgotPassword($email){
        if(customer_supplier::countEmailExisted($email) > 0) {
            $subject = 'Reset mật khẩu tài khoản đăng nhập';
            $content = 'Xin chào: {{name}}<br>Chúng tôi vừa nhận được yêu cầu đổi mật khẩu của bạn <br>Mã xác nhận: {{email_password}}';
            $email_password = Util::generateOTP(6);
            $name = customer_supplier::where('email', $email)->first()->name;

            $content = str_replace("{{email_password}}", $email_password, $content);
            $content = str_replace("{{name}}", $name, $content);

            $send_mail = Util::sendMail($email, $subject, $content);
            if(!$send_mail) {
                return 'messages.error';
            }
            $query = customer_supplier::where('email', $email)->update(['email_password' => $email_password]);
            if(!$query) {
                return 'messages.error';
            }
            return 'messages.success';

        }
        return 'messages.not_existed_account';
    }

    public static function updatePasswordByEmail($email, $email_password, $new_password){
        if(customer_supplier::checkValidEmailPassword($email, $email_password) > 0){
            $query = customer_supplier::where('email', $email)->update([
                'password' => sha1($new_password),
                'email_password' => null
            ]);

            if($query){
                return 'messages.success';
            }
            return 'messages.error';
        }
        return 'messages.password_incorrect';
    }

    public static function exportListCustomer($shop_id, $customer_name, $status, $customer_flg) {
        if($customer_flg) {
            $list_customer  = self::getListCustomer($shop_id, $customer_name, $status);
        }
        else {
            $list_customer  = self::getListSupplier($shop_id, $customer_name, $status);
        }

        $data_customer = [];
        $cnt = 0;
        foreach ($list_customer as $item) {
            $cnt++;
            $data_customer[] = [
                $cnt,
                $item->name,
                $item->group_name,
                $item->tax_code,
                $item->address,
                $item->email,
                $item->tel,
                $item->website,
                $item->notes
            ];
        }
        return $data_customer;
    }

    public static function exportCustomerExcelTransaction($customers) {
    	$data_success = $data_error = [];

		foreach ($customers as $row) {
			$msg_error = [];

			if(!$row[1]) {
				$msg_error[] = __('messages.customer_name_null');
			}

			if(!$row[2]) {
				$msg_error[] = __('messages.group_customer_name_null');
			}

			if($row[5] && !filter_var($row[5], FILTER_VALIDATE_EMAIL)) {
				$msg_error[] = __('messages.invalid_email');
			}

			if($msg_error) {
				$data_error[] = [
					'name' => $row[1],
					'group_name' => $row[2],
					'tax_code' => $row[3],
					'address' => $row[4],
					'email' => $row[5],
					'tel' => $row[6],
					'website' => $row[7],
					'notes' => $row[8],
					'msg_error' => $msg_error
				];
			}
			else {
				$data_success[] = [
					'name' => $row[1],
					'group_name' => $row[2],
					'tax_code' => $row[3],
					'address' => $row[4],
					'email' => $row[5],
					'tel' => $row[6],
					'website' => $row[7],
					'notes' => $row[8],
					'msg_error' => []
				];
			}
		}

		$data = ['success' => $data_success, 'error' => $data_error];
		return $data;
	}

	public static function importCustomers($customers, $shop_id) {
    	foreach ($customers as $customer) {
			//customer email unique in system
    		$new_customer = customer_supplier::where([
				'customer_flg' => 1,
				'invalid' => 0,
			])->whereRaw("(email = '{$customer['email']}' or tel = '{$customer['tel']}')")
			  ->first();

    		if(!$new_customer) {
    			$new_customer = new customer_supplier();
			}

			$group_name = $customer['group_name'];
    		unset($customer['group_name']);

    		$customer_group = customer_supplier_group::where([
    			'shop_id' => $shop_id,
				'group_name' => $group_name,
				'customer_flg' => 1,
				'invalid' => 0,
			])->first();

    		if(!$customer_group) {
    			$customer_group = new customer_supplier_group();
    			$customer_group->shop_id = $shop_id;
    			$customer_group->group_name = $group_name;
    			$customer_group->customer_flg = 1;
    			$customer_group->invalid = 0;
    			$customer_group->regdate = Util::getNow();
    			$customer_group->save();
			}

			$customer['shop_id'] = $shop_id;
			$customer['customer_flg'] = 1;
			$customer['status'] = 1;
			$customer['groupid'] = $customer_group->id;
			$new_customer->fill($customer);
			$new_customer->regdate = Util::getNow();
			$new_customer->save();
		}
	}

	public static function createOrUpdateCustomerAgency($shop_id, $data) {
        DB::beginTransaction();
        try {
            $create_account_flg = false;
            $data['id'] = empty(trim($data['id'])) ? 0 : $data['id'];
            $data['shop_id_create'] = empty(trim($data['shop_id_create'])) ? 0 : $data['shop_id_create'];
            $shop_info = shop::getShopById($shop_id);
            $data_shop = [
                'name' => $data['name'],
                'email' => $data['email'],
                'tel' => $data['tel'],
                'address' => $data['address'],
                'tax' => $data['tax_code'],
                'web_title' => $data['name'],
                'type' => $shop_info ? $shop_info->type : 1,
                'sidebar_color' => $shop_info ? $shop_info->sidebar_color : 'lightgray',
                'sidebar_text_color' => $shop_info ? $shop_info->sidebar_text_color : 'black',
                'sidebar_text_selected_color' => $shop_info ? $shop_info->sidebar_text_selected_color : 'red',
                'logo_image' => $_SERVER['APP_URL'] . '/upload/shop_logo/2.png'
            ];

            $data_customer = [
                'name' => $data['name'],
                'email' => $data['email'],
                'address' => $data['address'],
                'groupid' => $data['groupid'],
                'notes' => $data['notes'],
                'status' => $data['status'],
                'tax_code' => $data['tax_code'],
                'tel' => $data['tel'],
                'website' => $data['website'],
                'id' => $data['id'],
                'shop_id' => $data['shop_id'],
                'customer_flg' => 1
            ];
            if($data['username'] && $data['password']) {
                $create_account_flg = true;
            }
            $data_account = [
                'username' => $data['username'],
                'password' => $data['password'],
                'full_name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['tel'],
                'address' => $data['address'],
                'role' => Constant::ROLE_SHOP_OWNER,
                'is_shop' => 1,
                'available' => isset($data['available']) ? intval($data['available']) : 1
            ];
            $role_id = $data['role_permission'];
            $shop_constant_id = $data['shop_constant_id'];
            $shop_create_id = $data['shop_id_create']; // shop_id của account customer agency
            if(isset($data_customer['id']) && $data_customer['id']) {
                customer_supplier::updateOrInsert(['id' => $data_customer['id']], $data_customer);
                if($create_account_flg) {
                    $get_shop_id_create = shop::createOrUpdateShop($data_shop, intval($shop_create_id));
                    $data_account['shop_id'] = $get_shop_id_create;
                    $data_account['last_update_date'] = Util::getNow();
                    $account_id = account::updateOrInsertAccountCustomerAgency($data_account, $data['account_id'], $role_id);
                    shop::updateAccountId($shop_create_id, $account_id);
                    shop_constant_role_permission::createOrUpdateConstantRolePermission($shop_id, $shop_create_id, $role_id, $shop_constant_id);
                    customer_supplier::where('id', $data_customer['id'])->update(['access_account_id' => $account_id]);
                    shop_order_statistic::addDefaultShopOrderStatistic($shop_create_id);
                    shop_setting::addShopSettingDefault($shop_create_id);
                    asset::addWalletDefault($account_id, $shop_create_id);
                }
                else if(isset($data['account_id']) && intval($data['account_id'])){
                    account::updateStatusLogin($data['account_id'], $data_account['available']);
                }
            }
            else {
				$data_customer['regdate'] = Util::getNow();
                $last_id = customer_supplier::insertGetId($data_customer);
                if($create_account_flg) {
                    $shop_create_id = shop::createOrUpdateShop($data_shop);
                    $level = shop_level::getLevelByShopId($shop_id);
                    $data_account['shop_id'] = $shop_create_id;
                    $data_account['main_shopid'] = $shop_create_id;
					$data_account['regdate'] = Util::getNow();
                    $account_id = account::updateOrInsertAccountCustomerAgency($data_account, null, $role_id);
                    shop::updateAccountId($shop_create_id, $account_id);
                    shop_level::createShopLevel($shop_id, $shop_create_id, $level);
                    shop_constant_role_permission::createOrUpdateConstantRolePermission($shop_id, $shop_create_id, $role_id, $shop_constant_id);
                    customer_supplier::where('id', $last_id)->update(['access_account_id' => $account_id]);
                    shop_order_statistic::addDefaultShopOrderStatistic($shop_create_id);
                    shop_setting::addShopSettingDefault($shop_create_id);
                    asset::addWalletDefault($account_id, $shop_create_id);
                }
                else if(isset($data['account_id']) && intval($data['account_id'])){
                    account::updateStatusLogin($data['account_id'], $data_account['available']);
                }
            }

            DB::commit();
            /*$data_reponse = [
                'msg' =>__('messages.success'),
                'status_error' => 0
            ];*/
            if(isset($data_customer['id']) && $data_customer['id'] != null){
                $id_success = $data_customer['id'];
            }else{
                $id_success = $last_id;
            }
            $data_reponse = self::getCustomerAgencyDetail($id_success, $shop_id);
            return $data_reponse;//$data_reponse;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            /*$data_reponse = [
                'msg' => $exception->getMessage(),
                'status_error' => 1
            ];*/
//            $data_reponse = 0;
//            return $data_reponse;
			return $exception->getMessage();
        }
    }

    public static function getCustomerAgencyDetail($id, $shop_id) {
        $query = customer_supplier::where([
            'customer_supplier.id' => $id,
            'customer_supplier.shop_id' => $shop_id,
            'customer_supplier.invalid' => 0,
            'customer_supplier.customer_flg' => 1,
        ])->leftJoin('account', function ($join) {
                $join->on('customer_supplier.access_account_id', '=', 'account.id');
            })->leftJoin('shop_constant_role_permission', function ($join) {
                $join->on('shop_constant_role_permission.shop_id', '=', 'account.main_shopid');
            })->leftJoin('role_permission', function ($join) {
                $join->on('role_permission.id',  '=', 'shop_constant_role_permission.parent_shop_role_permission_id');
            })->select([
                'customer_supplier.id',
                'customer_supplier.name',
                'customer_supplier.groupid',
                'customer_supplier.address',
                'customer_supplier.tel',
                'customer_supplier.notes',
                'customer_supplier.tax_code',
                'customer_supplier.email',
                'customer_supplier.website',
                'customer_supplier.status',
                'role_permission.role_name',
                DB::raw('shop_constant_role_permission.id as shop_constant_id'),
                DB::raw('shop_constant_role_permission.parent_shop_role_permission_id as role_permission'),
                'account.username',
                'account.available',
                DB::raw('account.main_shopid as shop_id_create'),
                DB::raw('account.id as account_id'),
        ])->first();

        return $query;
    }

    public static function getListCustomerAgencyDetail($shop_id, $status, $name) {
        $query = customer_supplier::where([
            'customer_supplier.shop_id' => $shop_id,
            'customer_supplier.invalid' => 0,
            'customer_supplier.status' => $status,
            'customer_supplier.customer_flg' => 1,
        ])->leftJoin('customer_supplier_group', function ($join){
            $join->on('customer_supplier_group.id', '=', 'customer_supplier.groupid');
        })->leftJoin('account', function ($join) {
            $join->on('customer_supplier.access_account_id', '=', 'account.id');
        })->leftJoin('shop_constant_role_permission', function ($join) {
            $join->on('shop_constant_role_permission.shop_id', '=', 'account.main_shopid');
        })->leftJoin('role_permission', function ($join) {
            $join->on('role_permission.id',  '=', 'shop_constant_role_permission.parent_shop_role_permission_id');
        });

        if($name) {
            $query = $query->whereRaw("customer_supplier.name like '%{$name}%'");
        }
        $query = $query->select([ //$query->whereRaw('customer_supplier.access_account_id > 0')
            'customer_supplier.id',
            'customer_supplier.name',
            'customer_supplier_group.group_name',
            'customer_supplier.address',
            'customer_supplier.tel',
            'customer_supplier.notes',
            'customer_supplier.tax_code',
            'customer_supplier.email',
            'customer_supplier.website',
            'customer_supplier.status',
            'customer_supplier.access_account_id',
            'role_permission.role_name',
            'account.username',
            'account.available',
        ])->groupBy('customer_supplier.id')->get();

        return $query;
    }

    public static function getDataCustomerAgencyExportExcel($shop_id, $name, $status) {
        $data = self::getListCustomerAgencyDetail($shop_id, $status, $name);
        $data_list = [];
        if($data) {
            $cnt = 0;
            foreach ($data as $item) {
                $cnt++;
                $data_list[] = [
                    $cnt,
                    $item->name,
                    $item->group_name,
                    $item->username,
                    $item->role_name,
                    $item->tax_code,
                    $item->address,
                    $item->email,
                    $item->tel,
                    $item->website,
                    $item->notes
                ];
            }
        }
        return $data_list;
    }

    public static function checkAccountAgency($account_id, $shop_id) {
        $customer = customer_supplier::where([
            'shop_id' => $shop_id,
            'access_account_id' => $account_id,
            'invalid' => 0
        ])->first();

        return $customer ? $account_id : 0;
    }

    public static function deleteCustomerAgency($shop_id, $id, $account_id = 0) {
        DB::beginTransaction();
        try{
            self::deleteCustomerSupplier($id, $shop_id);
            if($account_id && intval($account_id)) {
//                account::where(['id' => $account_id])->update(['available' => 0]);
				account::deleteAccount($account_id);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public static function getListShopAgency($shop_id) {
        $data = customer_supplier::where([
            'customer_supplier.shop_id' => $shop_id,
            'customer_supplier.invalid' => 0,
            'customer_supplier.customer_flg' => 1
        ])
        ->join('account', function ($join) {
            $join->on('account.id', '=', 'customer_supplier.access_account_id')
                ->on('account.available', '=', DB::raw(1));
        })
        ->join('customer_supplier_group', function ($join) {
            $join->on('customer_supplier_group.id', '=', 'customer_supplier.groupid');
        })
        ->select(
            'customer_supplier.name',
            DB::raw('account.main_shopid as shop_id'),
            'customer_supplier_group.group_name',
            'customer_supplier.groupid'
        )->orderBy('groupid')->groupBy('customer_supplier.id')->get();


        $data_list = $data_sub = $data_response = [];
        if($data) {
            foreach ($data as $item) {
                $data_list[$item->groupid] = $item->group_name;
            }
            foreach ($data_list as $k =>  $item) {
                $data_sub = [];
                foreach ($data as $key => $item_data) {
                    if($item_data->groupid == $k) {
                        $data_sub[] = [
                            'name' => $item_data->name,
                            'shop_id' => $item_data->shop_id
                        ];
                    }
                }
                $data_response[$item] = $data_sub;
            }
        }

        return $data_response;
    }

    public static function getListShopAgencyName($shop_id) {
        $data = customer_supplier::where([
            'customer_supplier.shop_id' => $shop_id,
            'customer_supplier.invalid' => 0,
            'customer_supplier.customer_flg' => 1
        ])
        ->join('account', function ($join) {
            $join->on('account.id', '=', 'customer_supplier.access_account_id')
                ->on('account.available', '=', DB::raw(1));
        })
        ->select(
            'customer_supplier.name',
            DB::raw('account.main_shopid as shop_id')
        )->orderBy('groupid')->groupBy('customer_supplier.id')->get();

        return $data;
    }
}
