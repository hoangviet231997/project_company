<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class commission_master extends Model
{
    protected $table = 'commission_master';
    protected $timestamp = false;

    public static function getListCommission($shop_id,$name,$group_id, $status){
        $response = commission_master::select([
            'commission_master.id',
            'commission_master.name',
            'commission_master.customer_supplier_group_id',
            'commission_master.start_date',
            'commission_master.end_date',
            'commission_master.note',
            DB::raw('customer_supplier_group.group_name as group_name')
        ]);

        $response->leftJoin('customer_supplier_group', function($join){
            $join->on('commission_master.customer_supplier_group_id', '=', 'customer_supplier_group.id');
        });

        if(!empty($name)){
            $response->whereRaw("(commission_master.name like '%{$name}%' or commission_master.note like '%{$name}%')");
        }
        if(intval($group_id)){
            $response->where('commission_master.customer_supplier_group_id',$group_id);
        }

        $response->where([
            'commission_master.shop_id' => $shop_id,
            'commission_master.invalid' => 0,
            'commission_master.status' => $status
        ]);
        return $response->get();
    }

    public static function getCommissionDetail($shop_id, $id){
        $data = [];
        $details =  DB::table('commission_master')
        ->join('commission_detail', function ($join) {
            $join->on('commission_detail.commission_master_id', '=', 'commission_master.id');
        })
        ->leftJoin('customer_supplier_group', function ($join) {
            $join->on('customer_supplier_group.id', '=', 'commission_master.customer_supplier_group_id');
        })
        ->join('product', function ($join) {
            $join->on('product.product_id', '=', 'commission_detail.product_id');
        })
        ->where([['commission_detail.commission_master_id',$id],['commission_detail.invalid',0]])
        ->select(
            'commission_master.name',
            'commission_master.shop_id',
            'commission_master.status',
            'commission_master.customer_supplier_group_id',
            'commission_master.note','commission_master.start_date',
            'commission_master.end_date',
            'commission_detail.id',
            'commission_detail.commission_master_id',
            'commission_detail.product_amount',
            'commission_detail.commission_percent',
            'customer_supplier_group.group_name',
            'product.product_id',
            'product.product_name',
            'product.unit_name')
        ->get();

        if(count($details) == 0 ){
            return 'messages.not_found';
        }
        foreach($details as $detail){
            $commission_master_id = $detail->commission_master_id;
            $name = $detail->name;
            $shop_id = $detail->shop_id;
            $customer_supplier_group_id = $detail->customer_supplier_group_id;
            $customer_supplier_group_name = $detail->group_name;
            $note = $detail->note;
            $start_date = $detail->start_date;
            $end_date = $detail->end_date;
            $data_details[] =[
                'id' => $detail->id,
                'product_amount' => $detail->product_amount,
                'commission_percent' => $detail->commission_percent,
                'product_id' => $detail->product_id,
                'product_name' => $detail->product_name,
                'unit_name' => $detail->unit_name
            ];
        }

        $data = [
            'commission_master_id' => $commission_master_id,
            'name' => $name,
            'shop_id' => $shop_id,
            'customer_supplier_group_id' => $customer_supplier_group_id,
            'customer_supplier_group_name' => $customer_supplier_group_name,
            'note' => $note,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'details' => $data_details
        ];
        return $data;
    }

    public static function updateOrInsertCommission($data, $id){
        if(strlen($data->start_date) <= 10){
            $data->start_date = $data->start_date.' 00:00:01';
        }
        if(strlen($data->end_date) <= 10){
            $data->end_date = $data->end_date.' 23:59:59';
        }
        $data = [
            'name'=>$data->name,
            'shop_id'=>$data->shop_id,
            'customer_supplier_group_id'=>$data->customer_supplier_group_id,
            'note'=>$data->note,
            'status'=>$data->status,
            'start_date'=>Carbon::parse($data->start_date)->format('Y-m-d H:i:s'),
            'end_date'=>Carbon::parse($data->end_date)->format('Y-m-d H:i:s'),
            'products'=>$data->products
        ];
        if($id == null){////create
            $master = new commission_master;
            $regdate = Carbon::now();
        }else{///update
            $master = commission_master::find($id);
            if($master == null){
                return 'messages.not_found  ';
            }
            $regdate =  $master->regdate;

            DB::table('commission_detail')->where([['commission_master_id',$id],['invalid',0]])->update(['invalid' => 1]);
        }
        $master->name = $data['name'];
        $master->shop_id = $data['shop_id'];
        $master->customer_supplier_group_id = $data['customer_supplier_group_id'];
        $master->note = $data['note'];
        $master->status = $data['status'];
        $master->start_date = $data['start_date'];
        $master->end_date = $data['end_date'];
        $master->timestamps = false;
        $master->regdate = $regdate;
        $master->update_date = Carbon::now();
        $master->save();

        $products = $data['products'];
        foreach($products as $product){
            $detail = DB::table('commission_detail')->insert([
                'commission_master_id' => $master->id,
                'product_id' => $product['product_id'],
                'product_amount' => $product['product_amount'],
                'commission_percent' => $product['commission_percent']
            ]);
        }
		if(isset($master) && $detail){
			return 'messages.success';
		}
		return 'messages.error';
    }

    public static function deleteCommission($shop_id, $id){
        $data = '';
        DB::beginTransaction();
        try {
            DB::table('commission_master')
            ->where([
                'id'=>$id,
                'shop_id'=>$shop_id,
                'invalid'=>0
                ])
            ->update(['invalid' => 1]);
            DB::table('commission_detail')
            ->where([
                'commission_master_id'=>$id,
                'invalid'=>0
                ])
            ->update(['invalid' => 1]);
            DB::commit();
        } catch (\Exception $e) {
            $data = $e->getMessage();
            DB::rollBack();
        }

        return  $data;
    }
}
