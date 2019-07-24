<?php
////tmp hide
//namespace App\Http\Controllers\Api\v1;
//
//use Illuminate\Http\Request;
//use App\Models\account_commission;
//
//class AccountCommissionController extends Controller
//{
//    public function getListAccountCommission(Request $request){
//        $response = account_commission::getListAccountCommission($request->shop_id);
//        return $this->respondSuccess($response);
//    }
//
//    public function getAccountCommissionDetail(Request $request){
//        if($request->id){
//            $response = account_commission::getAccountCommissionDetail($request->shop_id, $request->id);
//            return $this->respondSuccess($response);
//        }
//        else{
//            return $this->respondMissingParam();
//        }
//    }
//
//    public function newAccountCommission(Request $request){
//        if($request->account_id && $request->commission_id){
//            $data = $request->except(['token', 'id']);
//            $query = account_commission::updateOrInsertAccountCommission($data);
//
//            if($query == 'messages.success'){
//                return $this->respondSuccess();
//            }
//            else{
//                return $this->respondError(__($query));
//            }
//        }
//        else{
//            return $this->respondMissingParam();
//        }
//    }
//
//    public function updateAccountCommission(Request $request){
//        if($request->id){
//            $id = $request->id;
//            $data = $request->except(['token', 'id']);
//
//            $response = account_commission::updateOrInsertAccountCommission($data, $id);
//            if($response == 'messages.success'){
//                return $this->respondSuccess();
//            }
//            else{
//                return $this->respondError(__($response));
//            }
//        }
//        else{
//            return $this->respondMissingParam();
//        }
//    }
//
//    public function deleteAccountCommission(Request $request){
//        if($request->id){
//            $response = account_commission::deleteAccountCommissionById($request->shop_id, $request->id);
//            if($response){
//                return $this->respondSuccess();
//            }
//            return $this->respondError();
//        }
//        else{
//            return $this->respondMissingParam();
//        }
//    }
//
//
//}
