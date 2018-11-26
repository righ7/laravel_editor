<?php

namespace App\Admin\Models\GoodsCard;

use Illuminate\Database\Eloquent\Model;

class GoodsGroup extends Model
{
    protected $table = 'goods_group';
    protected $guarded = [];
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function details()
    {
        return $this->hasMany('App\Admin\Models\GoodsCard\GoodsGroupDetail');
    }
}
