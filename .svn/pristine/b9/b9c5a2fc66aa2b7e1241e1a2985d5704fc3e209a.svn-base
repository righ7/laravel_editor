<?php

namespace App\Admin\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleSensitiveWord extends Model
{
    //

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('article.article_sensitive_word'));

        parent::__construct($attributes);
    }

}
