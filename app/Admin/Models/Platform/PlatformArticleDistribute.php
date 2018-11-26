<?php

namespace App\Admin\Models\Platform;

use Illuminate\Database\Eloquent\Model;
use App\Application\TeMai\Models\Article\Traits\Attribute\ArticleChannelAttribute;

/**
 * Class TeMai
 * package App
 */
class PlatformArticleDistribute extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	protected $primaryKey = 'id';

	protected $guarded = [];

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

	/**
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = config('article.platform_article_distribute');
	}

	// 关联 article 模型
	public function article()
    {
	    return $this->belongsTo('App\Admin\Models\Article\Article');
    }

    // 关联 platform 模型
    public function platform()
    {
        return $this->belongsTo('App\Admin\Models\Platform\Platform');
    }
}
