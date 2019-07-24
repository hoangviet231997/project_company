<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shop_level extends Model
{
    public $table = 'shop_level';

    public static function createShopLevel($shop_parent_id, $shop_id, $level) {
        $shop_level = new shop_level();
        $shop_level->shop_id = $shop_id;
        $shop_level->shop_parent_id =  $shop_parent_id;
        $shop_level->level = $level;
        $shop_level->save();
        if(!$shop_level->id) {
            throw new \Exception(__('messages.can\'t_save') . 'shop_level', 1);
        }
    }

    public static function getLevelByShopId($shop_id) {
        $shop_level = shop_level::where(['shop_id' => $shop_id])->select('level')->first();
        if($shop_level) {
            return $shop_level->level + 1;
        }
        else { //when not exists shop_level
            self::createShopLevel(0, $shop_id, 1);
            return 2;
        }
    }
}
