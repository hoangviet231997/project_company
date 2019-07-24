<?php

namespace App\Helper;

class Constant {
	const SHOP_BUSINESS_START_HOUR = '00:00:01';
	const RULE_TIMEOUT_EXPIRED_TOKEN = '3 MINUTES';
	const DEFAULT_LANGCODE = 'vi';
	const SUCCESS = 'success';
	const
		ROLE_SHOP_OWNER = 1,
		ROLE_SHOP_STAFF = 6;
	const
	    SYNC_ORDER_NEW = 0,
	    SYNC_ORDER_UPDATE_SERVER = 2,
	    SYNC_ORDER_UPDATE_LOCAL = 1;
	const
        DEVICE_TYPE_ANDROID = 0,
        DEVICE_TYPE_IOS = 1;
    const
        APP_TYPE_ANDROID_STAFF = 0,
        APP_TYPE_IOS_USER = 1,
        APP_TYPE_IOS_MANAGER = 2,
        APP_TYPE_IOS_STAFF = 3;
	const
		LIMIT_PAGINATION = 10,
		MAX_LIMIT_PAGINATION = 500;
	const
		GROUP_TABLE_ID = 9999999,
		GROUP_TABLE_NAME = 'Khác';
	const
		ORDER_NEW = 0,
		ORDER_IN_PROCESS = 1,
		ORDER_WRAP = 2,
		ORDER_DELIVERY = 3,
		ORDER_COMPLETED = 4,
		ORDER_CANCEL = 5,
		ORDER_MERGED = 8,
		ORDER_CHECKIN = 10,
		ORDER_CHECKOUT = 11,
		ORDER_BOOKING = 12;
    const
		LIMIT_BATCH_EXPIRE_DATE = 10,
        OUT_OF_STOCK = 10,
        LIMIT_TOP_SALE_PRODUCT = 10;
	const
		PREFIX_ORDER_CODE_DEFAULT = 'BH',
		EXPIRE_ORDER_CODE_DEFAULT = 3; //year
	const
		TRASACTION_TYPE_IMPORT = 1,
		TRASACTION_TYPE_EXPORT = 2,
        TRANSACTION_SUBTYPE_ORDER = 1;
	const
		TRASACTION_NORMAL = 0, //Bình thường
		TRASACTION_FROM_ORDER = 1, //Xuất phát từ bán hàng
		TRANSACTION_FROM_PAY = 2, //Trả nợ
		TRANSACTION_FROM_PAY_SUPPLIER = 3, //Trả nợ từ nhà cung cấp
		TRANSACTION_FROM_INVENTORY = 4; //Phát sinh từ kho
	const
		UNIT_TYPE_ALL = 0,
		UNIT_TYPE_GOODS = 1,
		UNIT_TYPE_SERVICE = 2;
	const
		LIST_ORDER_BOOOKING_TYPE_BOOKING = 1,
		LIST_ORDER_BOOOKING_TYPE_CHECKIN = 2,
		LIST_ORDER_BOOOKING_TYPE_CHECKOUT = 3;
	const
		PUSH_TYPE_NEW_ORDER = 0,
		PUSH_TYPE_UPDATE_ORDER = 1;
	const
		ROLE_PERMISSION_RECEIVE_NOTI_ORDER = 69;

	const
        DOMAIN_API = 'http://api_giangson.posapp.vn';
	const
		PRODUCT_TYPE_GOODS = 1,
		PRODUCT_TYPE_SERVICE = 2;
	const
        PERMISSION_CREATE_CUSTOMER_AGENCY = 70;
	const
		SHOP_TYPE_PHARMACY = 1,
		SHOP_TYPE_SPA = 2,
		SHOP_TYPE_DISTRIBUTOR = 3,
		SHOP_TYPE_RETAIL = 4;
    const
        CUSTOMER_AGENCY_REGISTER_PARENT_SHOP_ID = 15;
    public static function getSubType($type, $sub_type) {
        switch ($type) {
            case '1':
                switch ($sub_type) {
                    case '1':
                        return 'Mua';
                        break;
                    case '2':
                        return 'Nhập hủy HD';
                        break;
                    case '3':
                        return 'Nhập nội bộ';
                        break;
                    case '4':
                        return 'Nhập chuyển';
                        break;
                }
            case '2':
                switch ($sub_type) {
                    case '1':
                        return 'Do bán hàng';
                        break;
                    case '2':
                        return 'Xuất trả hàng';
                        break;
                    case '3':
                        return 'Xuất nội bộ';
                        break;
                    case '4':
                        return 'Xuất chuyển';
                        break;
                    case '6':
                        return 'Xuất định lượng bán hàng';
                        break;
                }
        }
    }

    public static $field_required_transaction_check_stock = [
        'dateCreated',
        'account_id',
        'account_name',
        'shop_id',
        'facility_id',
    ];

    public static $field_required_transaction_provided_receive = [
        'dateCreated',
        'account_id',
        'account_name',
        'total',
        'paidTotal',
    ];

    public static $field_require_transaction = [
        1 => [ //Nhap xuat tu nha cung cap
            'transaction_with_name',
            'transaction_with_id',
            'dateCreated',
            'total',
            'paidTotal',
            'account_id',
            'account_name',
            'shop_id',
            'facility_id',
        ],
        2 => [ //Nhap tra tu khach hang
            'transaction_with_name',
            'transaction_with_id',
            'dateCreated',
            'total',
            'paidTotal',
            'account_id',
            'account_name',
            'shop_id',
            'facility_id',
        ],
        3 => [ //Nhap Noi bo
            'dateCreated',
            'total',
            'paidTotal',
            'account_id',
            'account_name',
            'shop_id',
            'facility_id',
        ],

        4 => [ // Nhap xuat chuyen
            'dateCreated',
            'total',
            'paidTotal',
            'account_id',
            'account_name',
            'shop_id',
            'shop_id_provided',
            'facility_id_provided',
            'shop_id_reveived',
            'facility_id_received',
        ],
        5 => [ //nhap ton
            'dateCreated',
            'total',
            'paidTotal',
            'account_id',
            'account_name',
            'shop_id',
            'facility_id',
        ]
    ];

	public static
		$LIST_STATUS_SERVED_ARRAY = [4, 7],
		$LIST_STATUS_SERVE_ARRAY = [0, 1, 2, 3, 9],
		$LIST_STATUS_COMPLETED_ARRAY = [4, 5, 7, 8];

	public static $DEFAULT_ALL_PERMISSIONS_SHOP_TYPE_DISTRIBUTOR = [32, 53, 54, 55, 58, 59, 70];

	public static function getAllPermission() {
		$permission = [
			//Thiết lập
			__('role_permission.setting') => [
				'52' => __('role_permission.setting_shop'),
				'53' => __('role_permission.manage_all'),
				'54' => __('role_permission.manage_staff'),
				'55' => __('role_permission.manage_customer'),
//				'56' => 'deleteServer',
//				'57' => 'deleteLocal',
				'58' => __('role_permission.setting_role'),
				'59' => __('role_permission.manage_supplier'),
//				'60' => 'chooseStaffOrder',
//				'61' => 'changePrintOption',
				'70' => __('role_permission.create_account_system'),
			],
			//Bán hàng
			__('role_permission.sale') => [
				'2' => __('role_permission.order_option'),
				'3' => __('role_permission.modify_VAT'),
				'4' => __('role_permission.taking_a_payment'),
				'5' => __('role_permission.cancel_unpaid_bill'),
				'6' => __('role_permission.cancel_paid_bill'),
//				'8' => 'viewStaffLayout',
				'16' => __('role_permission.displayo_order_his'),//'displayoOrderHis',
				'9' => __('role_permission.cancel_item'),
				'10' => __('role_permission.modify_item_price'),
//				'68' => 'modifyTopping',
				'13' => __('role_permission.adjust_item_order'),
//				'14' => 'quickSale',
//				'15' => 'provisionalBill',
//				'62' => 'splitTable',
//				'63' => 'mergeTable',
//				'64' => 'changeTable',
//				'66' => 'orderSetting',
//				'67' => 'allowOpenCloseShift',
//				'65' => 'viewAllTransaction',
				'69' => __('role_permission.receive_noti_order'),
			],
//			//Báo cáo
			__('role_permission.report') => [
				'42' => __('role_permission.report_today_actives'),
				'43' => __('role_permission.bussiness_status'),
				'44' => __('role_permission.number_customer'),
				'45' => __('role_permission.revenue'),
				'46' => __('role_permission.customer_dept'),
				'47' => __('role_permission.bill_his'),
			],
			//Xuất nhập kho
			__('role_permission.report_stock') => [
				'32' => __('role_permission.adjust_stock'),
				'33' => __('role_permission.adjust_stock_in_out'),
				'34' => __('role_permission.inventory_checking'),
			],
//			//Thu chi
//			__('transaction') => [
//				'22' => 'newReceiptPayment',
//				'23' => 'updateReciptpayment',
//				'24' => 'viewAdjusBalance',
//			],
		];
		return $permission;
	}

    public static $CURRENCY_DENOMINATION = [
        '¥' => '{"currencyDenominationModelList":[{"denomination":1.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""},{"denomination":500.0,"index":0,"note":""},{"denomination":1000.0,"index":0,"note":""},{"denomination":2000.0,"index":0,"note":""},{"denomination":5000.0,"index":0,"note":""},{"denomination":10000.0,"index":0,"note":""}]}',
        '$' => '{"currencyDenominationModelList":[{"denomination":0.01,"index":0,"note":""},{"denomination":0.05,"index":0,"note":""},{"denomination":0.1,"index":0,"note":""},{"denomination":0.25,"index":0,"note":""},{"denomination":0.5,"index":0,"note":""},{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""}]}',
        'C$' => '{"currencyDenominationModelList":[{"denomination":0.01,"index":0,"note":""},{"denomination":0.05,"index":0,"note":""},{"denomination":0.1,"index":0,"note":""},{"denomination":0.25,"index":0,"note":""},{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""}]}',
        'đ' => '{"currencyDenominationModelList":[{"denomination":1000.0,"index":0,"note":""},{"denomination":2000.0,"index":0,"note":""},{"denomination":5000.0,"index":0,"note":""},{"denomination":10000.0,"index":0,"note":""},{"denomination":20000.0,"index":0,"note":""},{"denomination":50000.0,"index":0,"note":""},{"denomination":100000.0,"index":0,"note":""},{"denomination":200000.0,"index":0,"note":""},{"denomination":500000.0,"index":0,"note":""}]}',
        '€' => '{"currencyDenominationModelList":[{"denomination":0.01,"index":0,"note":""},{"denomination":0.02,"index":0,"note":""},{"denomination":0.05,"index":0,"note":""},{"denomination":0.1,"index":0,"note":""},{"denomination":0.2,"index":0,"note":""},{"denomination":0.5,"index":0,"note":""},{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""},{"denomination":200.0,"index":0,"note":""},{"denomination":500.0,"index":0,"note":""}]}',
        'руб' => '{"currencyDenominationModelList":[{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""},{"denomination":500.0,"index":0,"note":""},{"denomination":1000.0,"index":0,"note":""},{"denomination":5000.0,"index":0,"note":""}]}',
        'CN¥' => '{"currencyDenominationModelList":[{"denomination":0.1,"index":0,"note":""},{"denomination":0.2,"index":0,"note":""},{"denomination":0.5,"index":0,"note":""},{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""}]}',
        'Ft' => '{"currencyDenominationModelList":[{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""},{"denomination":200.0,"index":0,"note":""},{"denomination":500.0,"index":0,"note":""},{"denomination":1000.0,"index":0,"note":""},{"denomination":5000.0,"index":0,"note":""},{"denomination":10000.0,"index":0,"note":""},{"denomination":20000.0,"index":0,"note":""}]}',
        'HK$' => '{"currencyDenominationModelList":[{"denomination":0.1,"index":0,"note":""},{"denomination":0.2,"index":0,"note":""},{"denomination":0.5,"index":0,"note":""},{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""},{"denomination":500.0,"index":0,"note":""},{"denomination":1000.0,"index":0,"note":""}]}',
        'A$' => '{"currencyDenominationModelList":[{"denomination":0.05,"index":0,"note":""},{"denomination":0.1,"index":0,"note":""},{"denomination":0.2,"index":0,"note":""},{"denomination":0.5,"index":0,"note":""},{"denomination":1.0,"index":0,"note":""},{"denomination":2.0,"index":0,"note":""},{"denomination":5.0,"index":0,"note":""},{"denomination":10.0,"index":0,"note":""},{"denomination":20.0,"index":0,"note":""},{"denomination":50.0,"index":0,"note":""},{"denomination":100.0,"index":0,"note":""}]}',
    ];

    /*'€' 'руб' '$ (Canadian)'*/
    public static $CURRENCY_LANGCODE = [
        'ja' => '¥',
        'en' => '$',
        'vi' => 'đ',
        'zh' => 'CN¥',
        'zh-rCN' => 'CN¥',
    ];
}
