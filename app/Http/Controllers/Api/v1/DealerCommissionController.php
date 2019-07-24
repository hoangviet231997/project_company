<?php
////tmp hide
//namespace App\Http\Controllers\Api\v1;
//
//use Illuminate\Http\Request;
//use App\Models\dealer_commission;
//
//class DealerCommissionController extends Controller
//{
//    public function getListDealerCommission(Request $request){
//        $response = dealer_commission::getListDealerCommission($request->shop_id);
//        return $this->respondSuccess($response);
//    }
//
//    public function getDealerCommissionDetail(Request $request){
//        if($request->id){
//            $response = dealer_commission::getDealerCommissionDetail($request->shop_id, $request->id);
//            return $this->respondSuccess($response);
//        }
//        else{
//            return $this->respondMissingParam();
//        }
//    }
//
//    public function newDealerCommission(Request $request){
//        if($request->dealer_id && $request->commission_id){
//            $data = $request->except(['token', 'id']);
//            $query = dealer_commission::updateOrInsertDealerCommission($data);
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
//    public function updateDealerCommission(Request $request){
//        if($request->id){
//            $id = $request->id;
//            $data = $request->except(['token', 'id']);
//
//            $response = dealer_commission::updateOrInsertDealerCommission($data, $id);
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
//    public function deleteDealerCommission(Request $request){
//        if($request->id){
//            $response = dealer_commission::deleteDealerCommissionById($request->shop_id, $request->id);
//            if($response){
//                return $this->respondSuccess();
//            }
//            return $this->respondError();
//        }
//        else{
//            return $this->respondMissingParam();
//        }
//    }
//}
