<?php

namespace App\Admin\Models\GoodsCard;

use Illuminate\Database\Eloquent\Model;

class TemaiGoodsSearchConfig extends Model
{
    protected $table = 'temai_goods_search_config';
    protected $guarded = [];
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}
