<?php

namespace App\Admin\Models\Article;

use Illuminate\Database\Eloquent\Model;

//目标人群和分类表   type='target_population' 为目标人群   type='taobao_article' 为分类
class ArticleCategory extends Model
{
    //
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('article.article_category'));

        parent::__construct($attributes);
    }

}
