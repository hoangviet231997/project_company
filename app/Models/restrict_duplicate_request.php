<?php

namespace App\Models;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;

class restrict_duplicate_request extends Model {
	protected $table = 'restrict_duplicate_request';
	public $timestamps = false;

	public static function saveRestrictDuplicateRequest($action, $local_id, $shop_id) {
		$restrict = new restrict_duplicate_request();
		$restrict->action = $action;
		$restrict->local_id = $local_id;
		$restrict->shop_id = $shop_id;
		$restrict->regdate = Util::getNow();
		return $restrict->save();
	}
}