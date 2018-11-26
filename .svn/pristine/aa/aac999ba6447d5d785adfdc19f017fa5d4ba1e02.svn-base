<?php

use Illuminate\Routing\Router;


Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin');
    //文章
    Route::group(['namespace' => 'Article'], function () {
        Route::resource('articles','MyPublishController');
        Route::resource('ttarticles','TtMyPublishController');

        // 批量生成
        Route::any('mass_production','MassProductionController@index');
        Route::group(['prefix' => 'mass_production'],function () {
            Route::any('omission_goods','MassProductionController@omission_goods')->name('mass_production/omission_goods');
            Route::any('putch','MassProductionController@putch')->name('mass_production/putch');
            Route::any('get_favorite_goods','MassProductionController@getFavoriteGoods')->name('mass_production/get_favorite_goods');
            Route::any('save_img_collection','MassProductionController@saveImgCollection')->name('mass_production/save_img_collection');
            Route::any('save_album','MassProductionController@saveAlbum')->name('mass_production/save_album');
            Route::any('produce','MassProductionController@produce')->name('mass_production/produce');
            Route::any('get_template','MassProductionController@getTemplate')->name('mass_production/get_template');
        });

        // 审核 & 分发
        Route::group(['prefix' => 'article_audit_distrubute'], function () {
            Route::any('audit_index', 'ArticleAuditDistributeController@auditIndex')->name('ArticleAuditDistribute.auditIndex');
            Route::any('distribute_index', 'ArticleAuditDistributeController@distributeIndex')->name('ArticleAuditDistribute.distributeIndex');
            Route::any('audit_ajax', 'ArticleAuditDistributeController@auditAjax')->name('ArticleAuditDistribute.auditAjax');
            Route::any('distribute_ajax', 'ArticleAuditDistributeController@distributeAjax')->name('ArticleAuditDistribute.distributeAjax');
            Route::any('pass', 'ArticleAuditDistributeController@pass')->name('ArticleAuditDistribute.pass');
            Route::any('reject', 'ArticleAuditDistributeController@reject')->name('ArticleAuditDistribute.reject');
            Route::any('distribute_random', 'ArticleAuditDistributeController@distributeRandom')->name('ArticleAuditDistribute.distributeRandom');
            Route::any('distribute', 'ArticleAuditDistributeController@distribute')->name('ArticleAuditDistribute.distribute');
            Route::any('cancel_distribute', 'ArticleAuditDistributeController@cancelDistribute')->name('ArticleAuditDistribute.cancelDistribute');
            Route::any('cancel_all_distribute', 'ArticleAuditDistributeController@cancelAllDistribute')->name('ArticleAuditDistribute.cancelAllDistribute');
        });


        Route::group(['prefix' => 'article/{article}'], function() {
            //文章预览页面
            Route::any('preview', 'ArticlePublicController@ArticlePreview')->name('article.preview');
        });
        Route::any('article/get_preview_data', 'ArticlePublicController@getArticleData')->name('article.get_preview_data');

        Route::post('articles/change_article_status/{id}','MyPublishController@changeArticleStatus')->name('articles/change_article_status');

        //敏感词列表
        Route::resource('article/sensitive_word_list','ArticleSensitiveWordController');
        //全网好文
        Route::resource('article/day_good_article','ArticleDayGoodArticleController');
        //自有好文
        Route::any('article/day_good_article_we','ArticleDayGoodArticleWeController@index')->name('article.index');
        //特卖文章
        Route::resource('temai_article/temai_good_article','ArticleTemaiGoodArticleController');
            //获取数据
            Route::any('temai_article/article_data','ArticleTemaiGoodArticleController@articleData')->name('temai_article.articleData');
            //达人排行榜
            Route::any('temai_article/author_rank','AuthorRankController@index')->name('temai_article.author_rank');
            Route::any('temai_article/author_data','AuthorRankController@authorData')->name('temai_article.author_data');
            //查看文章详情
            Route::any('temai_article/good_article_detail','GoodsArticleDetailController@index')->name('temai_article.good_article_detail');
            Route::any('temai_article/good_article_detail_data','GoodsArticleDetailController@getData')->name('temai_article.good_article_detail_data');
            //复制爆文存草稿
            Route::any('temai_article/article_copy_all','GoodsArticleDetailController@copyAll')->name('temai_article.article_copy_all');
            //复制爆本单品
            Route::any('temai_article/article_copy_single','GoodsArticleDetailController@copySingle')->name('temai_article.article_copy_single');
        //关注页面
        Route::resource('temai_article/concern_gods_index','ConcernGodsController');
            //初始数据
            Route::any('temai_article/get_gods_data','ConcernGodsController@getGodsData')->name('temai_article.get_gods_data');
            //关注大神
            Route::any('temai_article/concern_god','ConcernGodsController@concernGod')->name('temai_article.concern_god');
            //是否已关注
            Route::any('temai_article/check_concerned','ConcernGodsController@checkConcerned')->name('temai_article.check_concerned');
            //取消关注
            Route::any('temai_article/cancel_concern','ConcernGodsController@cancelConcern')->name('temai_article.cancel_concern');
        //我的收益
        Route::resource('article/my_profit','MyProfitController');

            Route::any('article/get_revenue_initial_data','MyProfitController@getRevenueInitialData')->name('article.getRevenueInitialData');
            //收益订单详情
            Route::any('article/order_detail','MyProfitController@orderDetail')->name('article.orderDetail');
            Route::any('article/get_order_data','MyProfitController@getOrderData')->name('article.getOrderData');
            //全部收益
            Route::any('article/all_profit','MyProfitController@all')->name('article.all_profit');
                //获取数据
            Route::any('article/get_all_initial_data','MyProfitController@getAllInitialData')->name('article.get_all_initial_data');
        //发布专辑页面路由
//        Route::any('article/create_ablum','ArticleController@createAblumContent')->name('article.create_ablum');
//        Route::any('article/create_atlas','ArticleController@createAtlasContent')->name('article.create_atlas');

        //我的发文
        Route::any('article/my_article','MyArticleController@index')->name('article.my_article');


        //文章模板设置
        Route::resource('article_template','ArticleTemplateController');
        Route::any('article_template/store','ArticleTemplateController@store')->name('article_template.store');

        //保存图片接口
        Route::any('article/save_img', 'ArticlePublicController@saveArticleImg')->name('article.save_img');

    });
    //头条发布文章
    Route::group(['namespace' => 'ToutiaoArticle'], function () {
        //发布专辑页面路由
        Route::any('toutiao/create_ablum','ArticleController@createAblumContent')->name('toutiao.create_ablum');
        Route::any('toutiao/get_goods_data_view','ArticleController@getGoodsDataView')->name('toutiao.get_goods_data_view');
        Route::any('toutiao/get_goods_data','ArticleController@getGoodsDataApi')->name('toutiao.get_goods_data');

        Route::any('toutiao/save_img','ArticleController@saveArticleImg')->name('toutiao.save_img');


        Route::any('toutiao/save_article','ArticleController@SaveArticle')->name('toutiao.save_article');

        Route::group(['prefix' => 'toutiao/{article}'], function() {
            Route::any('edit_ablum', 'ArticleController@editAblum')->name('toutiao.edit_ablum');
        });

    });

    //发文管理
    Route::group(['namespace' => 'TeMaiArticle'], function () {
        //发布图集
        Route::any('article/add_pics/{article?}','AdminArticleController@index')->name('article.add_pics');
        //修改图集
//        Route::any('article/edit_pics/{article?}','AdminArticleController@editPics')->name('article.edit_pics');
        Route::group(['prefix' => 'article/{article}'], function() {
            Route::any('edit_pics', 'AdminArticleController@editPics')->name('article.edit_pics');
        });

        Route::any('article/get_select_goods','AdminArticleController@getSelectGoodsPreData')->name('article.get_select_goods');

        Route::any('article/select_goods_data','AdminArticleController@getSelectGoodsWaitData')->name('article.select_goods_data');

        //预览
        Route::any('article/preview_article_pics','AdminArticleController@setArticleStatus')->name('article.preview_article_pics');
        Route::any('article/preview_article_edit_pics','AdminArticleController@setArticleEditStatus')->name('article.preview_article_edit_pics');
        //存草稿
        Route::any('article/save_article_pics','AdminArticleController@saveArticlePics')->name('article.save_article_pics');
        //敏感词
        Route::any('article/sensitive_word','AdminArticleController@sensitiveWord')->name('article.sensitive_word');

        //换一换标题
        Route::any('article/get_change_goods_title','AdminArticleController@getChangeGoodsTitle')->name('article.get_change_goods_title');          //换一换主描述
        Route::any('article/get_change_goods_describe','AdminArticleController@getChangeGoodsDescribe')->name('article.get_change_goods_describe');
        //换一换副图描述
        Route::any('article/get_change_goods_subdescribe','AdminArticleController@getChangeGoodsSubDescribe')->name('article.get_change_goods_subdescribe');

        //敏感词内容校验
        Route::any('article/check_content_sensitiveWord','AdminArticleController@checkContentSensitiveWord')->name('article.check_content_sensitiveWord');

        //清除敏感词
        Route::any('article/change_sensitiveWord','AdminArticleController@changeSensitiveWord')->name('article.change_sensitiveWord');

        //提交审核
        Route::any('article/audit_article','AdminArticleController@auditArticle')->name('article.audit_article');
        //平台标题重复率检测
        Route::any('article/check_platform_article_title','AdminArticleController@checkArticleTitle')->name('article.check_platform_article_title');




        //以下是专辑的路由
        //创建专辑页面
        Route::any('article/create_ablum','ArticleAlbumController@createAblumContent')->name('article.create_ablum');
        Route::any('article/save_article','ArticleAlbumController@SaveArticle')->name('article.save_article');
        Route::any('article/get_template_list','ArticleAlbumController@getTemplateList')->name('article.get_template_list');


        Route::group(['prefix' => 'article/{article}'], function() {
            Route::any('edit_ablum', 'ArticleAlbumController@editAblum')->name('article.edit_ablum');
        });

    });

    //一些公共数据的接口
    Route::group(['namespace' => 'Base'], function () {
        //获取分类的接口
        Route::any('base/get_categories','BaseApiController@getCategoriesType')->name('base.get_categories');
        Route::any('base/get_img_data','BaseApiController@getArticleImg')->name('base.get_img_data');
        Route::any('base/get_des_data','BaseApiController@getArticleDescription')->name('base.getArticleDescription');

    });

    // 商品卡 - 商品分组
    Route::prefix('goods_group')->namespace('GoodsCard')->group(function () {
        Route::get('get_goods_group', 'GoodsGroupController@getGoodsGroup')->name('goods_group/get_goods_group');
        Route::get('get_goods_group_detail', 'GoodsGroupController@getGoodsGroupDetail')->name('goods_group/get_goods_group_detail');
        Route::get('curd_goods_group', 'GoodsGroupController@curdGoodsGroup')->name('goods_group/curd_goods_group');
        Route::get('curd_goods_group_detail', 'GoodsGroupController@curdGoodsGroupDetail')->name('goods_group/curd_goods_group_detail');
        Route::get('find_goods_in_group', 'GoodsGroupController@findGoodsInGroup')->name('goods_group/find_goods_in_group');
    });

    // 商品卡 - 商品标签
    Route::prefix('goods_tag')->namespace('GoodsCard')->group(function () {
        Route::get('get_goods_tags', 'GoodsTagController@getGoodsTags')->name('goods_tag.get_goods_tags');
        //商品反馈
        Route::any('add_feed_back', 'GoodsTagController@addFeedBack')->name('goods_tag.add_feed_back');

    });

    // 商品卡 - 店铺搜索
    Route::prefix('temai_goods_search_config')->namespace('GoodsCard')->group(function () {
        Route::get('get_shop', 'TemaiGoodsSearchConfigController@getShop')->name('temai_goods_search_config/get_shop');
    });
    // 商品卡 - 商品缺失反馈
    Route::prefix('omission_goods')->namespace('GoodsCard')->group(function () {
        Route::get('submit_goods', 'OmissionGoodsController@submitGoods')->name('omission_goods/submit_goods');
    });
    // 分发结果
    Route::get('article_distribute_result','Article\ArticleDistributeResultController@index');
    Route::post('article_distribute_result/delete/{id}','Article\ArticleDistributeResultController@delete')->name('article_distribute_result/delete');
    Route::post('article_distribute_result/transpond_article','Article\ArticleDistributeResultController@transpondArticle')->name('article_distribute_result/transpondArticle');


    //账号发文设置
    Route::group(['namespace' => 'Auth'], function () {
        //发文账号设置列表
        Route::any('auth/account_temai','AccountTemaiController@index')->name('auth.account_temai');
        //获取列表信息
        Route::any('auth/get_temai_list_data','AccountTemaiController@getTemaiListData')->name('auth.get_temai_list_data');
        //是否启用开关
        Route::any('auth/change_is_on','AccountTemaiController@changeIsOn')->name('auth.change_is_on');
        //批量设置小店图集/专辑数
        Route::any('auth/up_all_reset_num','AccountTemaiController@upAllResetNum')->name('auth.up_all_reset_num');
     //批量重置
        Route::any('auth/restart_all','AccountTemaiController@restartAll')->name('auth.restart_all');


        //发文账号列表
        Route::any('auth/account_data_list','AccountTemaiController@accountDataList')->name('auth.account_data_list');
        //获取列表数据
        Route::any('auth/get_account_data_list','AccountTemaiController@getAccountDataList')->name('auth.get_account_data_list');



    });


    //内容管理
    Route::group(['namespace' => 'ContentManage'], function () {
        //店铺配置
        Route::any('content/shop_config','ShopConfigController@index')->name('content.shop_config');
        //获取数据
        Route::any('content/ajax','ShopConfigController@ajax')->name('content.ajax');
        //添加店铺
        Route::any('content/create','ShopConfigController@create')->name('content.create');
        //删除
        Route::any('content/destroy','ShopConfigController@destroy')->name('content.destroy');
        //修改
        Route::any('content/update','ShopConfigController@update')->name('content.update');


        //问题反馈
        Route::any('content/feed_back','FeedBackController@index')->name('content.feed_back');
        //获取数据
        Route::any('content/get_data','FeedBackController@getData')->name('content.get_data');


    });



});
