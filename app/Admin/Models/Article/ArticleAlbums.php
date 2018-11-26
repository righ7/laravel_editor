<?php

namespace App\Admin\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleAlbums extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('article.article_albums'));

        parent::__construct($attributes);
    }

}
