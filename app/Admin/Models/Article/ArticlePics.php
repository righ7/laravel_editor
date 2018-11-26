<?php

namespace App\Admin\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticlePics extends Model
{
    protected $guarded = [];
    protected $table = 'article_pics';

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        parent::__construct($attributes);
    }

}
