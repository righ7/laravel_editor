<?php

namespace App\Admin\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class UserComany extends Model
{
    //

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('access.user_company'));

        parent::__construct($attributes);
    }

    public function user_company(){
        $user = config('admin.database.users_model');

        return $this->belongsTo($user,'compang_id','id');

    }
}
