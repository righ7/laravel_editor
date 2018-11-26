<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('login', 'Admin\Controllers\Api\ArticleIssueController@login');
Route::group(['namespace' => 'Admin\Controllers\Api', 'prefix' => 'article_issue'], function () {
    Route::any('write_distribute_status', 'ArticleIssueController@writeDistributeStatus');
});

Route::group(['namespace' => 'Http', 'as' => 'api.'], function () {
    Route::group([
        'namespace' => 'Controllers',
    ], function () {
        Route::group(['namespace' => 'User'], function () {
            //判断用户的登录和密码
            Route::any('user/user_login', 'UserApiController@UserLogin')->name('user.user_login');
        });

        Route::group(['namespace' => 'Article'], function () {
            //获取要发布的文章的数据
            Route::any('toutiao/get_article_data', 'ToutiaoArticleApiController@getArticleData')->name('toutiao.get_article_data');


            Route::any('article/writing_distribute_status', 'ArticleIssueApiController@writeDistributeStatu')->name('article.writing_distribute_status');
        });
        Route::group(['namespace' => 'DingDingMessage'], function () {
            Route::any('dingding/send_message', 'DingdingmessageApiController@sendMessage')->name('dingding.send_message');

        });

    });
});
