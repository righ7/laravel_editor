<?php

namespace App\Admin\Models\Platform;

use Illuminate\Database\Eloquent\Model;
use App\Application\TeMai\Models\Article\Traits\Attribute\ArticleChannelAttribute;

/**
 * Class TeMai
 * package App
 */
class Platform extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	protected $primaryKey = 'id';


	/**
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = config('article.platform');
	}
}
