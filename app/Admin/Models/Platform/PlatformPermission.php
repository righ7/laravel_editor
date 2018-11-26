<?php

namespace App\Admin\Models\Platform;

use Illuminate\Database\Eloquent\Model;
use App\Application\TeMai\Models\Article\Traits\Attribute\ArticleChannelAttribute;

/**
 * Class TeMai
 * package App
 */
class PlatformPermission extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	protected $primaryKey = 'id';

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

	/**
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = config('article.platform_permission');
	}
}
