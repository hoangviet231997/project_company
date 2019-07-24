<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\commission_master;
use App\Helpers\Util;

class CommissionController extends Controller
{
    public function getListCommission(Request $request){
        if($request->shop_id){
            $response = commission_master::getListCommission($request->shop_id, $request->name, $request->customer_supplier_group_id, $request->status);
            return $this->respondSuccess($response);
        }else{
            return $this->respondMissingParam();
        }
    }

    public function getCommissionDetail(Request $request){
        $response = commission_master::getCommissionDetail($request->shop_id, $request->id);
        if($response == 'messages.not_found'){
            return $this->respondNotFound();
        }
        return $this->respondSuccess($response);
    }

    public function newCommission(Request $request){
        if($request->customer_supplier_group_id && $request->products && $request->shop_id && $request->name){
            foreach($request->products as $product){
                if(!$product['product_id'] || !$product['product_amount'] || !$product['commission_percent']){
                    return $this->respondMissingParam();
                }
            }
            $query = commission_master::updateOrInsertCommission($request, null);

            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError(__($query));
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateCommission(Request $request){
        if($request->customer_supplier_group_id && $request->products && $request->shop_id && $request->name && $request->id){
            $query = commission_master::updateOrInsertCommission($request, $request->id);

            if($query == 'messages.success'){
                return $this->respondSuccess();
            }elseif($query == 'messages.not_found'){
                return $this->respondNotFound();
            }
            else{
                return $this->respondError(__($query));
            }
            // return $query;
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function deleteCommission(Request $request){
        if($request->id){
            $response = commission_master::deleteCommission($request->shop_id, $request->id);
            if($response == ''){
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        else{
            return $this->respondMissingParam();
        }
    }
}
