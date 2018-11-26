<?php

namespace App\Admin\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleTemplateSign extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('article.article_template_sign'));

        parent::__construct($attributes);
    }

}
