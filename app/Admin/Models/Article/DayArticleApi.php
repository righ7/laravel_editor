<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-17
 * Time: 上午 10:16
 */

namespace App\Admin\Models\Article;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class DayArticleApi extends Model
{
    public function paginate()
    {
        $perPage = Request::get('per_page', 20);

        $page = Request::get('page', 1);

        $column = Request::get('column', null);

        $data = file_get_contents("http://tm.youdnr.com/api/temai/article/day_hotarticle?article_type=0&page=$page&page_count=$perPage&plate=$column");

        $data = json_decode($data, true);

        //$data=$data['data'];

        extract($data);

        $looks = static::hydrate($data);

        $paginator = new LengthAwarePaginator($looks, $total, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }
}