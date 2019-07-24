<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class debug_log extends Model
{
    protected $table = 'debug_log';

    public static function saveDebugLog($name, $data) {
		$debug_log = new debug_log();
		$debug_log->name = $name;
		$debug_log->log = json_encode($data);
		$debug_log->save();
	}
}
