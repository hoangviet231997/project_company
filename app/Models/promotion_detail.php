<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promotion_detail extends Model
{
    protected $table = 'promotion_detail';

	public static function updatePromotionDetailById($promotion_detail_id, $use_amount) {
		$promotion_detail = promotion_detail::find($promotion_detail_id);
		$promotion_detail->amount_used = $promotion_detail->amount_used + ($use_amount);
		$promotion_detail->save();
		return $promotion_detail->amount_used;
	}
}
