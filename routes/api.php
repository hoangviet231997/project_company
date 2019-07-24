<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'cors'], function () {
	Route::post('login', 'Api\v1\LoginController@login');
    Route::post('newAccount', 'Api\v1\AccountController@updateOrInsertAccount');
    Route::post('customer/register', 'Api\v1\CustomerSupplierController@registerNewCustomer');
    Route::post('getDefaultRoleInformation', 'Api\v1\RolePermissionController@getDefaultRoleInformation');
    Route::post('getDefaultAgencyGroup','Api\v1\CustomerSupplierGroupController@getDefaultAgencyGroup');
    Route::post('registerCustomerAgency', 'Api\v1\CustomerSupplierController@registerCustomerAgency');
});

Route::any('test', 'Api\v1\Controller@test');

//spa
Route::any('getLayout', 'Api\v1\LoginController@getLayout');
Route::any('customer/login', 'Api\v1\CustomerSupplierController@login');
Route::post('getListPublicShop', 'Api\v1\ShopController@getPublicShop');
Route::post('public/getAccessToken', 'Api\v1\AppIdentifyController@getAccessToken');

Route::group(['middleware' => 'validateToken'], function () {
	Route::post('syncOrder', 'Api\v1\SyncOrderController@index');
	Route::post('getListCategory', 'Api\v1\ProductCategoryController@getListCategory');
    Route::post('getCategoryDetail', 'Api\v1\ProductCategoryController@getCategoryDetail');
    Route::post('newCategory', 'Api\v1\ProductCategoryController@insertCategory');
    Route::post('updateCategory', 'Api\v1\ProductCategoryController@updateCategory');
    Route::post('deleteCategory', 'Api\v1\ProductCategoryController@deleteCategory');

    Route::post('getListCategoryProduct', 'Api\v1\ProductCategoryController@getListCategoryProduct');

	Route::post('getListRack', 'Api\v1\RackController@getListRack');
    Route::post('getRackDetail', 'Api\v1\RackController@getRackDetail');
    Route::post('newRack', 'Api\v1\RackController@insertRack');
    Route::post('updateRack', 'Api\v1\RackController@updateRack');
    Route::post('deleteRack', 'Api\v1\RackController@deleteRack');

	Route::post('getListUnit', 'Api\v1\UnitController@getListUnit');
    Route::post('getUnitDetail', 'Api\v1\UnitController@getUnitDetail');
    Route::post('newUnit', 'Api\v1\UnitController@insertUnit');
    Route::post('updateUnit', 'Api\v1\UnitController@updateUnit');
    Route::post('deleteUnit', 'Api\v1\UnitController@deleteUnit');

	Route::post('getListFeature', 'Api\v1\FeatureController@getListFeature');
    Route::post('getFeatureDetail', 'Api\v1\FeatureController@getFeatureDetail');
    Route::post('newFeature', 'Api\v1\FeatureController@insertFeature');
    Route::post('updateFeature', 'Api\v1\FeatureController@updateFeature');
    Route::post('deleteFeature', 'Api\v1\FeatureController@deleteFeature');

    Route::post('getListProduct', 'Api\v1\ProductController@getListProduct');
    Route::post('deleteProductById', 'Api\v1\ProductController@deleteProductById');

    Route::post('getListSupplier','Api\v1\CustomerSupplierController@getListSupplier');
    Route::post('getListCustomer','Api\v1\CustomerSupplierController@getListCustomer');
    Route::post('getCustomerSupplierDetail','Api\v1\CustomerSupplierController@getCustomerSupplierDetail');

    Route::post('getListSupplierGroup','Api\v1\CustomerSupplierGroupController@getListSupplierGroup');
    Route::post('getListCustomerGroup','Api\v1\CustomerSupplierGroupController@getListCustomerGroup');
    Route::post('getCustomerSupplierGroupDetail','Api\v1\CustomerSupplierGroupController@getCustomerSupplierGroupDetail');

    Route::post('newCustomer','Api\v1\CustomerSupplierController@updateOrInsertCustomerSupplier')->defaults('is_customer', 1);
    Route::post('editCustomer','Api\v1\CustomerSupplierController@updateOrInsertCustomerSupplier')->defaults('is_customer', 1);
    Route::post('deleteCustomer','Api\v1\CustomerSupplierController@deleteCustomerSupplier');

    Route::post('newSupplier','Api\v1\CustomerSupplierController@updateOrInsertCustomerSupplier');
    Route::post('editSupplier','Api\v1\CustomerSupplierController@updateOrInsertCustomerSupplier');
    Route::post('deleteSupplier','Api\v1\CustomerSupplierController@deleteCustomerSupplier');

    Route::post('newCustomerGroup','Api\v1\CustomerSupplierGroupController@insertCustomerSupplierGroup')->defaults('is_customer', 1);
    Route::post('editCustomerGroup','Api\v1\CustomerSupplierGroupController@updateCustomerSupplierGroup')->defaults('is_customer', 1);
    Route::post('deleteCustomerGroup','Api\v1\CustomerSupplierGroupController@deleteCustomerSupplierGroup');

    Route::post('newSupplierGroup','Api\v1\CustomerSupplierGroupController@insertCustomerSupplierGroup');
    Route::post('editSupplierGroup','Api\v1\CustomerSupplierGroupController@updateCustomerSupplierGroup');
    Route::post('deleteSupplierGroup','Api\v1\CustomerSupplierGroupController@deleteCustomerSupplierGroup');

    Route::post('getListInvTransactionMasterByBill','Api\v1\InventoryTransactionController@getListInvTransactionMasterByBill');
    Route::post('getListInvTransacMasterByProduct','Api\v1\InventoryTransactionController@getListInvTransactionMasterByProduct');

    Route::post('getProductDetail','Api\v1\ProductController@getProductDetail');

    Route::post('getListInventory','Api\v1\ProductController@getListInventory');

    Route::post('getListHistoryBillForProduct','Api\v1\InventoryTransactionController@getListHistoryBillForProduct');

    Route::post('getInventoryTransactionDetail','Api\v1\InventoryTransactionController@getInventoryTransactionDetail');

    Route::post('getListInventoryDetail','Api\v1\InventoryTransactionController@getListInventoryDetail');
    Route::post('getListInventory','Api\v1\ProductController@getListInventory');

    Route::post('newProduct', 'Api\v1\ProductController@newProduct');
	Route::post('updateProduct', 'Api\v1\ProductController@updateProduct');
	Route::post('newProduct2', 'Api\v1\ProductController@newProduct');
	Route::post('updateProduct2', 'Api\v1\ProductController@updateProduct');

    Route::post('getListProductExtend','Api\v1\ProductController@getListProductExtend');
    Route::post('getListProductExtendByShopid','Api\v1\ProductController@getListProductExtendByShopid');
    Route::post('getListProductMaster','Api\v1\ProductController@getListProductMaster');
    Route::post('getProductUnit','Api\v1\ProductController@getProductUnit');
    Route::post('getProductUnitByProductMaster','Api\v1\ProductController@getListUnitByProductMaster');

    Route::post('getListOrder','Api\v1\OrderController@getListOrder');
    Route::post('getOrderDetail','Api\v1\OrderController@getOrderDetail');
    Route::post('updateOrderBookingStatus','Api\v1\OrderController@updateOrderBookingStatus');
    Route::post('getListOrderType','Api\v1\OrderTypeController@getListOrderType');
    Route::post('getOrderTypeDetail','Api\v1\OrderTypeController@getOrderTypeDetail');
    Route::post('newOrderType','Api\v1\OrderTypeController@newOrderType');
    Route::post('updateOrderType','Api\v1\OrderTypeController@updateOrderType');
    Route::post('deleteOrderType','Api\v1\OrderTypeController@deleteOrderType');

    Route::post('createBillTransaction', 'Api\v1\InventoryTransactionController@createBillInventoryTransaction');
    Route::post('editBillTransaction', 'Api\v1\InventoryTransactionController@editBillTransaction');
    Route::post('cancelBillTransaction', 'Api\v1\InventoryTransactionController@cancelBillTransaction');
    Route::post('createBillProvidedReceive', 'Api\v1\InventoryTransactionController@createBillProvidedReceive');
    Route::post('editBillProvidedReceive', 'Api\v1\InventoryTransactionController@editBillProvidedReceive');
    Route::post('verifyBillProvidedReceive', 'Api\v1\InventoryTransactionController@verifyBillProvidedReceive');

    Route::post('getListInventoryTransactionMaster','Api\v1\InventoryTransactionController@getListInventoryTransactionMaster');

    Route::post('getListStaff', 'Api\v1\StaffController@getListStaff');

    //list product search when create bill transaction
    Route::post('getListProductInInventory', 'Api\v1\ProductController@getListProductInInventory');

    /*app*/
    Route::post('getAllInventoryMaster', 'Api\v1\InventoryTransactionController@getAllInventoryMaster');
    Route::post('report', 'Api\v1\ReportController@index');
    Route::post('v2_report', 'Api\v1\ReportController@index')->defaults('v2', 1);

    Route::post('updateAccount', 'Api\v1\AccountController@updateOrInsertAccount')->defaults('is_update', 1);
    Route::post('deleteAccount', 'Api\v1\AccountController@deleteAccount');
    Route::post('getAccountDetail', 'Api\v1\AccountController@getAccountDetail');

    Route::post('getConstantRolePermission', 'Api\v1\RolePermissionController@getConstantRolePermission');
    Route::post('getListRolePermission', 'Api\v1\RolePermissionController@getListRolePermission');
    Route::post('getRolePermissionDetail', 'Api\v1\RolePermissionController@getRolePermissionDetail');
    Route::post('newRolePermission', 'Api\v1\RolePermissionController@updateOrInsertRolePermission');
    Route::post('updateRolePermission', 'Api\v1\RolePermissionController@updateOrInsertRolePermission')->defaults('is_update', 1);
    Route::post('deleteRolePermission', 'Api\v1\RolePermissionController@deleteRolePermission');

    Route::post('getListAsset', 'Api\v1\AssetController@getListAsset');
    Route::post('getAssetDetail', 'Api\v1\AssetController@getAssetDetail');
    Route::post('newAsset', 'Api\v1\AssetController@newAsset');
    Route::post('updateAsset', 'Api\v1\AssetController@updateAsset');
    Route::post('deleteAsset', 'Api\v1\AssetController@deleteAsset');

    Route::post('getListFacility', 'Api\v1\FacilityController@getListFacility');
    Route::post('getFacilityDetail', 'Api\v1\FacilityController@getFacilityDetail');
    Route::post('newFacility', 'Api\v1\FacilityController@newFacility');
    Route::post('updateFacility', 'Api\v1\FacilityController@updateFacility');
    Route::post('deleteFacility', 'Api\v1\FacilityController@deleteFacility');

    Route::post('updateShopSetting', 'Api\v1\ShopController@updateShopSetting');

    Route::post('getListArea', 'Api\v1\AreaController@getListArea');
    Route::post('getListAreaTable', 'Api\v1\AreaController@getListAreaTable');
    Route::post('getAreaDetail', 'Api\v1\AreaController@getAreaDetail');
    Route::post('newArea', 'Api\v1\AreaController@newArea');
    Route::post('updateArea', 'Api\v1\AreaController@updateArea');
    Route::post('deleteArea', 'Api\v1\AreaController@deleteArea');

    Route::post('getListTable', 'Api\v1\TableController@getListTable');
    Route::post('getTableDetail', 'Api\v1\TableController@getTableDetail');
    Route::post('newTable', 'Api\v1\TableController@newTable');
    Route::post('updateTable', 'Api\v1\TableController@updateTable');
    Route::post('deleteTable', 'Api\v1\TableController@deleteTable');

    Route::post('getListAccountGroup', 'Api\v1\AccountGroupController@getListAccountGroup');
    Route::post('getAccountGroupDetail', 'Api\v1\AccountGroupController@getAccountGroupDetail');
    Route::post('newAccountGroup', 'Api\v1\AccountGroupController@newAccountGroup');
    Route::post('updateAccountGroup', 'Api\v1\AccountGroupController@updateAccountGroup');
    Route::post('deleteAccountGroup', 'Api\v1\AccountGroupController@deleteAccountGroup');

    Route::post('getListCommission', 'Api\v1\CommissionController@getListCommission');
    Route::post('getCommissionDetail', 'Api\v1\CommissionController@getCommissionDetail');
    Route::post('newCommission', 'Api\v1\CommissionController@newCommission');
    Route::post('updateCommission', 'Api\v1\CommissionController@updateCommission');
    Route::post('deleteCommission', 'Api\v1\CommissionController@deleteCommission');
    Route::post('getThreeGroup', 'Api\v1\AccountGroupController@getThreeGroup');
    Route::post('reportDashboard', 'Api\v1\OrderController@reportDashboard');
    //Route::post('exportDataProductExcel', 'Api\v1\ProductController@exportDataProductExcel');

//    Route::post('getListAccountCommission', 'Api\v1\AccountCommissionController@getListAccountCommission');
//    Route::post('getAccountCommissionDetail', 'Api\v1\AccountCommissionController@getAccountCommissionDetail');
//    Route::post('newAccountCommission', 'Api\v1\AccountCommissionController@newAccountCommission');
//    Route::post('updateAccountCommission', 'Api\v1\AccountCommissionController@updateAccountCommission');
//    Route::post('deleteAccountCommission', 'Api\v1\AccountCommissionController@deleteAccountCommission');

//    Route::post('getListDealerCommission', 'Api\v1\DealerCommissionController@getListDealerCommission');
//    Route::post('getDealerCommissionDetail', 'Api\v1\DealerCommissionController@getDealerCommissionDetail');
//    Route::post('newDealerCommission', 'Api\v1\DealerCommissionController@newDealerCommission');
//    Route::post('updateDealerCommission', 'Api\v1\DealerCommissionController@updateDealerCommission');
//    Route::post('deleteDealerCommission', 'Api\v1\DealerCommissionController@deleteDealerCommission');
    Route::post('importProductTransaction', 'Api\v1\ProductController@exportProductExcel');
    Route::post('importExcelTransaction', 'Api\v1\InventoryTransactionController@importExcelTransaction');

	Route::post('getListCustomerInventory', 'Api\v1\CustomerInventoryController@getListCustomerInventory');
	Route::post('newCustomerInventory', 'Api\v1\CustomerInventoryController@newCustomerInventory');
	Route::post('updateCustomerInventory', 'Api\v1\CustomerInventoryController@updateCustomerInventory');
	Route::post('deleteCustomerInventory', 'Api\v1\CustomerInventoryController@deleteCustomerInventory');

	/*import export excel*/
    Route::post('exportListCustomer', 'Api\v1\CustomerSupplierController@exportListCustomer');
	Route::post('importCustomerExcel', 'Api\v1\CustomerSupplierController@importCustomerExcel');
	Route::post('importCustomers', 'Api\v1\CustomerSupplierController@importCustomers');

	/*api for agency*/
    Route::post('createCustomerAgency', 'Api\v1\CustomerSupplierController@createOrUpdateCustomerAgency');
    Route::post('editCustomerAgency', 'Api\v1\CustomerSupplierController@createOrUpdateCustomerAgency');
    Route::post('getCustomerAgencyDetail', 'Api\v1\CustomerSupplierController@getCustomerAgencyDetail');
    Route::post('getListCustomerAgency', 'Api\v1\CustomerSupplierController@getListCustomerAgency');
    Route::post('checkPermissionCreateCustomerAgency', 'Api\v1\AccountController@checkPermissionCreateCustomerAgency');
    Route::post('exportListCustomerAgency', 'Api\v1\CustomerSupplierController@exportListCustomerAgency');
    Route::post('deleteCustomerAgency', 'Api\v1\CustomerSupplierController@deleteCustomerAgency');
    Route::post('getListShopAgency', 'Api\v1\CustomerSupplierController@getListShopAgency');
    Route::post('getAccountAgencyByShop', 'Api\v1\AccountController@getAccountAgencyByShop');


    /*api Course Detail */
    Route::post('getListCourseDetail','Api\v1\CourseDetailController@getListCourseDetail');
    Route::post('newCourseDetail' , 'Api\v1\CourseDetailController@newCourseDetail');
    Route::post('getCourseDetail' ,'Api\v1\CourseDetailController@getCourseDetail' );
    Route::post('updateCourseDetail' ,'Api\v1\CourseDetailController@updateCourseDetail' );
    Route::post('deleteCourseDetail' ,'Api\v1\CourseDetailController@deleteCourseDetail' );

    /*api Course Master */
    Route::post('getListCourseMaster','Api\v1\CourseMasterController@getListCourseMaster');
    Route::post('newCourseMaster' , 'Api\v1\CourseMasterController@newCourseMaster');
    Route::post('getCourseMaster' ,'Api\v1\CourseMasterController@getCourseMaster' );
    Route::post('updateCourseMaster' ,'Api\v1\CourseMasterController@updateCourseMaster' );
    Route::post('deleteCourseMaster' ,'Api\v1\CourseMasterController@deleteCourseMaster' );

    /*api Notification*/
    Route::post('getListNotification','Api\v1\NotificationController@getListNotification');
    Route::post('getNotificationDetail','Api\v1\NotificationController@getNotificationDetail');
    Route::post('newNotification','Api\v1\NotificationController@newNotification');
    Route::post('updateNotification','Api\v1\NotificationController@updateNotification');
    Route::post('deleteNotification','Api\v1\NotificationController@deleteNotification');
    Route::post('getListShopAgencyName', 'Api\v1\CustomerSupplierController@getListShopAgencyName');
    Route::post('getListNotificationByCurrentShop', 'Api\v1\NotificationController@getListNotificationByCurrentShop');

});


Route::group(['middleware' => 'validatePublicApp'], function () {
	Route::post('public/getListCategory', 'Api\v1\AppShopController@getListCategory');
    Route::post('public/getListProduct', 'Api\v1\AppShopController@getListProduct');
//	Route::post('public/getProductDetailForBooking', 'Api\v1\AppShopController@getProductDetailForBooking');

    Route::post('customer/forgotPassword', 'Api\v1\CustomerSupplierController@forgotPassword');
    Route::post('customer/updatePasswordByEmail', 'Api\v1\CustomerSupplierController@updatePasswordByEmail');
});

Route::group(['middleware' => 'validateUserToken'], function () {
    Route::post('customer/verifyOtp', 'Api\v1\CustomerSupplierController@verifyOtp');
    Route::post('customer/resendOtp', 'Api\v1\CustomerSupplierController@resendOtp');
    Route::post('customer/sendSms', 'Api\v1\CustomerSupplierController@sendSms');
    Route::post('customer/updateInfo', 'Api\v1\CustomerSupplierController@updateInfo');
    Route::post('customer/logout', 'Api\v1\CustomerSupplierController@logout');
	Route::post('customer/getListInventory', 'Api\v1\CustomerInventoryController@getListCustomerInventory');
});


