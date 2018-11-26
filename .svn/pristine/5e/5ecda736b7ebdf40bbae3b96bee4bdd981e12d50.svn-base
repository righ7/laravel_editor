<?php

namespace App\Admin\Models\Article;

use App\Admin\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    public function pics()
    {
        return $this->hasMany(ArticlePics::class);
    }

    public function albums()
    {
        return $this->hasMany(ArticleAlbums::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('article.article_table'));

        parent::__construct($attributes);
    }

}
