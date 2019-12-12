<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/*第八个月 微信 */
    /*接口*/
        /*Route::post('jiekou','JiekouController@jiekou');*/
    /*微信*/
        /*Route::get('wechat_add','WechatController@wechat_add');// 获取用户信息
        Route::get('wechat_index','WechatController@wechat_index'); // 获取用户列表
        Route::get('wechat_to_index','WechatController@wechat_to_index');;//粉丝列表
        Route::get('code','WechatController@code');*/


        /*
        Route::get('/wechat/get_user_info','WechatController@get_user_info');
        Route::get('/wechat/get_user_list','WechatController@get_user_list');
        Route::get('/wechat/user_list','WechatController@user_list');*/
        /*Route::get('push_template','WechatController@push_template');//推送模板消息
        Route::get('template_list','WechatController@template_list');//模板列表
        Route::get('del_template','WechatController@del_template');//删除模板*/
    //上传素材
        /*Route::get('/wechat/upload_source','WechatController@upload_source');
        Route::get('/wechat/get_source','WechatController@get_source');
        Route::get('/wechat/get_video_source','WechatController@get_video_source');
        Route::get('/wechat/get_voice_source','WechatController@get_voice_source');
        Route::post('wechat/do_upload','WechatController@do_upload');*/
    //用户标签相关
        /*Route::get('/wechat/add_tag','WechatController@add_tag'); //添加标签
        Route::post('/wechat/do_add_tag','WechatController@do_add_tag'); //执行添加标签
        Route::get('/wechat/tag_list','WechatController@tag_list'); //标签列表
        Route::get('/wechat/tag_user','WechatController@tag_user'); //标签下的粉丝列表
        Route::post('/wechat/add_user_tag','WechatController@add_user_tag'); //批量给用户打标签
        Route::get('/wechat/push_tag_message','WechatController@push_tag_message'); //根据标签推送消息
        Route::post('/wechat/do_push_tag_message','WechatController@do_push_tag_message'); //执行根据标签推送消息
        Route::get('/wechat/del_tag','WechatController@del_tag'); //删除标签
        Route::get('/wechat/update_tag','WechatController@update_tag'); //修改标签
        Route::post('/wechat/do_update_tag','WechatController@do_update_tag'); //执行修改标签

        Route::get('/wechat/get_user_tag','WechatController@get_user_tag'); //获取用户标签
        Route::get('/wechat/del_user_tag','WechatController@del_user_tag'); //删除用户标签
        Route::get('/wechat/get_access_token','WechatController@get_access_token');//獲取token*/
    /*微信生成二维码*/
        /*//Route::any('/event','AgentController@event');//微信接入
        Route::get('user_list','AgentController@user_list');//二维码的用户列表
        Route::get('create_qrcode','AgentController@create_qrcode');// 生成专属二维码*/
    /*自定义接口*/
        /*Route::get('menu_list','MenuController@menu_list');
        Route::get('del_menu','MenuController@del_menu');  //完全删除菜单
        Route::any('do_add_menu','MenuController@do_add_menu');  //增加菜单
        Route::get('display_menu','MenuController@display_menu');  //菜单查询接口
        Route::get('reload_menu','MenuController@reload_menu');  //刷新菜单接口*/
    //微信留言功能
        /*Route::get('w_login','WxLyController@w_login');
        //Route::get('code','WxLyController@code');
        Route::get('index','WxLyController@index');*/
    //表白
        /*Route::get('biaobai_list','BiaobaiController@biaobai_list');
        Route::get('biaobai','BiaobaiController@biaobai');//我要表白，表白添加
        Route::post('do_biaobai','BiaobaiController@do_biaobai');
        Route::get('push_template','BiaobaiController@push_template');
        Route::post('my_profession','BiaobaiController@my_profession');//我的表白*/
    //签到
        /*Route::get('qd_list','QiandaoController@qd_list');
        Route::any('do_qd','QiandaoController@do_qd');  //增加菜单
        Route::get('display_qd','QiandaoController@display_qd');  //菜单查询接口
        Route::get('qd_template','QiandaoController@qd_template');//根据openid发送模板消息
        Route::get('qd_push_template','QiandaoController@qd_push_template');//根据openid发送模板消息
        Route::any('event','QiandaoController@event');//微信接入*/

//--------------------------------------------------------------------------------------------------------------------------------------------------------------
/*route::get('get_access_token','aa\WechatController@get_access_token');//获取access_token

    Route::get('user_list','aa\WechatController@user_list');//用户列表
    Route::get('wechat_user_info','aa\WechatController@wechat_user_info');//用户列表
    Route::get('get_user_info','aa\WechatController@get_user_info');//用户列表
    Route::get('get_user_list','aa\WechatController@get_user_list');//用户列表

    route::get('upload','aa\WechatController@upload');//图片上传
    route::post('do_upload','aa\WechatController@do_upload');//图片上传
    Route::get('wechat_source','aa\WechatController@wechat_source'); //素材管理
    Route::get('download_source','WechatController@download_source'); //下载资源

    Route::get('clear_api','aa\WechatController@clear_api');//调用频次清0
    Route::get('push_template_message','aa\WechatController@push_template_message');//模板消息推送
    Route::get('location','aa\WechatController@location');//jssdk
    //微信授权登录
    route::get('do_login','aa\LoginController@do_login');
    route::post('login','aa\LoginController@login');*/
    //route::get('code','aa\LoginController@code');
    /*
    route::get('/send','aa\LoginController@send');



    Route::get('tag_list','aa\TagController@tag_list');//用户标签管理列表
    Route::get('add_tag','aa\TagController@add_tag');//添加
    Route::post('add_do_tag','aa\TagController@add_do_tag');//添加执行
    Route::get('tag_del','aa\TagController@tag_del');//
    Route::get('tag_update','aa\TagController@tag_update');//修改
    Route::post('do_update_tag','aa\TagController@do_update_tag');//修改执行

    Route::get('tag_openid_list','aa\TagController@tag_openid_list');//标签下用户的openid列表 //标签下的粉丝列表
    //Route::get('tag_user_list','aa\TagController@tag_user_list');//标签下的粉丝列表
    Route::post('add_user_tag','aa\TagController@add_user_tag');//为用户打标签
    Route::get('push_tag_message','aa\TagController@push_tag_message'); //推送标签消息
    Route::post('do_push_tag_message','aa\TagController@do_push_tag_message'); //执行推送标签消息
    Route::get('/wechat/user_tag_list','TagController@user_tag_list'); //用户下的标签列表
    Route::get('tag_openid_list','aa\TagController@tag_openid_list'); //标签下用户的openid列表
    Route::post('tag_openid','aa\TagController@tag_openid'); //为用户打标签


    Route::any('/event','aa\EventController@event');//接收微信发送的消息【用户互动】





    Route::get('agent_list','aa\AgentController@agent_list');
    Route::get('create_qrcode','aa\AgentController@create_qrcode');//生成专属的二维码




    //自定义菜单
    Route::get('menu_list','aa\MenuController@menu_list');//自定义菜单列表
    Route::post('create_menu','aa\MenuController@create_menu');//创建自定义菜单
    Route::get('menu_del','aa\MenuController@menu_del');//删除菜单
    Route::get('load_menu','aa\MenuController@load_menu');//根据数据库表数据刷新菜单




    //周考
    //Route::group(['middleware' => ['zhoukao']], function () {
    Route::get('zk_login','aa\ZhoukaoController@zk_login');
    Route::post('zk_do_login','aa\ZhoukaoController@zk_do_login');
    //Route::get('zk_code','aa\ZhoukaoController@zk_code');
    Route::get('zk_user_list','aa\ZhoukaoController@zk_user_list');//用户列表
    Route::get('wechat_user_info','aa\ZhoukaoController@wechat_user_info');//用户列表
    Route::get('zk_get_user_info','aa\ZhoukaoController@zk_get_user_info');//用户列表
    Route::get('zk_get_user_list','aa\ZhoukaoController@zk_get_user_list');//用户列表
    Route::get('zk_tag_list','aa\ZhoukaoController@zk_tag_list');//标签列表
    Route::get('zk_tag_add','aa\ZhoukaoController@zk_tag_add');//标签添加
    Route::post('zk_do_tag_add','aa\ZhoukaoController@zk_do_tag_add');//标签添加
    Route::post('zk_add_user_tag','aa\ZhoukaoController@zk_add_user_tag');//给用户打标签
    Route::get('zk_push_tag_message','aa\ZhoukaoController@zk_push_tag_message');//给标签下的粉丝推送消息
    Route::post('zk_do_push_tag_message','aa\ZhoukaoController@zk_do_push_tag_message');//给标签下的粉丝推送消息
    Route::post('zk_do_add_user_tag','aa\ZhoukaoController@zk_do_add_user_tag');
    Route::get('zk_tag_user','aa\ZhoukaoController@zk_tag_user');//标签下粉丝列表
    //})

    //签到
    Route::get('qd_list','aa\QiaodaoController@qd_list');//签到自定义菜单列表
    Route::post('qd_add','aa\QiaodaoController@qd_add');//签到添加
    Route::get('load_menu','aa\QiaodaoController@load_menu');//根据数据库表数据刷新菜单
    Route::get('qd_push_template_message','aa\QiaodaoController@qd_push_template_message');//根据数据库表数据刷新菜单


    //课程
    Route::get('k_list','aa\KechengController@k_list');//课程列表
    Route::post('k_add','aa\KechengController@k_add');//课程添加
    Route::post('k_login','aa\KechengController@k_login');//课程登录
    Route::get('k_do_login','aa\KechengController@k_do_login');//课程登录
    Route::get('k_code','aa\KechengController@k_code');//课程登录




    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //九月Api接口
        Route::get('index','admin\AdminController@index');//后台首页
        Route::get('h_login','admin\LoginController@h_login');//后台登录
        Route::any('h_do_login','admin\LoginController@h_do_login');//后台登录
        Route::get('send','admin\LoginController@send');//发送验证码
        Route::any('bdzh','admin\LoginController@bdzh');//绑定管理员账号
        Route::any('do_bdzh','admin\LoginController@do_bdzh');//绑定管理员账号

                                                      /*Api*/
//测试添加页
        /*    Route::get('/Api/test/test_a', function () {
                return view('Api.test.test_a');
            });
        //测试列表页
            Route::get('/Api/test/test_list', function () {
                return view('Api.test.test_list');
            });
            Route::get('/Api/test/test_update', function () {
                return view('Api.test.test_update');
            });

        //测试添加接口
            Route::any('test_list','Api\TestController@test_list');//测试列表
            Route::any('test_do','Api\TestController@test_do');//测试添加
            Route::any('test_update','Api\TestController@test_update');//测试添加
            Route::any('test_do_update','Api\TestController@test_do_update');//测试添加
            Route::any('test_delete','Api\TestController@test_delete');//测试删除

        //资源控制器
        Route::resource('api/user', 'Api\User1Controller');
        //周考 商品
        Route::get('/Api/goods/g_add', function () {
            return view('Api.goods.g_add');
        });//添加视图
        Route::get('/Api/goods/g_list', function () {
            return view('Api.goods.g_list');
        });
        Route::resource('api/goods', 'Api\1GoodsController');
        Route::any('api/weather','Api\GoodsController@weather');//天气
        Route::any('api/weach','Api\GoodsController@weach');//天气


                        //电商项目
        Route::get('/Api/goods/g_add', function () {
            return view('Api.goods.g_add');
        });//添加视图
        Route::resource('api/goods', 'Api\GoodsController');//商品添加


        //商品分类
        Route::get('api/cate_add','Api\CategoryController@cate_add');//分类添加
        Route::post('api/cate_do_add','Api\CategoryController@cate_do_add');//分类执行
        Route::get('api/cate_list','Api\CategoryController@cate_list');//分类列表

        Route::get('api/type_add','Api\CategoryController@type_add');//类型展示
        Route::get('api/type_add_do','Api\CategoryController@type_add_do');//类型添加
        Route::post('api/type_add_d','Api\CategoryController@type_add_d');//类型添加执行

        Route::get('api/attr_add','Api\CategoryController@attr_add');//属性添加
        Route::post('api/attr_do_add','Api\CategoryController@attr_do_add');//属性添加执行
        Route::get('api/attr_list','Api\CategoryController@attr_list');//属性列表
        Route::get('api/del','Api\CategoryController@del');


        Route::get('api/goods_add','Api\GoodsController@goods_add');
        Route::get('api/getAttr','Api\GoodsController@getAttr');//属性列表
        Route::post('api/add_do','Api\GoodsController@add_do');//属性列表
        Route::get('api/goods_list','Api\GoodsController@goods_list');//商品列表
        Route::get('del','Api\GoodsController@del');
        Route::get('cargo_add/{goods_id}','Api\GoodsController@cargo_add');//货品添加
        Route::post('cargo_do_add','Api\GoodsController@cargo_do_add');//货品添加




        Route::prefix('api')->middleware('apiheader')->group(function(){
            Route::get('news','api\NewsController@news');
            Route::get('goods_details','api\NewsController@goods_details');
            Route::any('goods_cate','api\NewsController@goods_cate');
            Route::any('goods_cate_do','api\NewsController@goods_cate_do');
            //用户登录接口 token
            Route::get('login','api\UserController@login'); 
            Route::get('getUser','api\UserController@getUser');
            Route::middleware('apiToken')->group(function(){
                //分组 所有登录之后才能调用接口
                 Route::any('cartAdd','api\NewsController@cartAdd');//加入购物车
                 Route::any('cartList','api\NewsController@cartList');//加入购物车列表
            });
        });
        //数组处理
        Route::get('stu_list','Api\ArrayController@stu_list');
        Route::get('class_list','Api\ArrayController@class_list');

        Route::get('/Api/register/zk_list', function () {
            return view('Api.register.zk_list');
        });
        Route::get('zk_add','Api\ZkController@zk_add');
        Route::get('zk_register','Api\ZkController@zk_register');
        Route::post('zk_register_do','Api\ZkController@zk_register_do');
        Route::get('zk1_login','Api\ZkController@zk1_login');
        Route::post('zk_login_do','Api\ZkController@zk_login_do');
        Route::get('zk_list','Api\ZkController@zk_list');


        Route::prefix('yuekao')->middleware('yuekao')->group(function(){
        //月考
            Route::get('yk_add','Api\YueKaoController@yk_add');

            Route::get('yk_list','Api\YueKaoController@yk_list');
        });

        Route::get('yk_register','Api\YueKaoController@yk_register');
        Route::post('yk_register_do','Api\YueKaoController@yk_register_do');
        Route::get('yk_login','Api\YueKaoController@yk_login');
        Route::post('yk_login_do','Api\YueKaoController@yk_login_do');
*/

//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
// 小程序
    /*Route::prefix('mini')->group(function(){
    Route::get('nav/index','miniProgram\NavController@index');//电视剧导航栏
    Route::get('nav/lists','miniProgram\IndexController@lists');
    Route::get('nav/cha','miniProgram\IndexController@cha');

});
*/


    /*
    pc端后台
     */
//登录
Route::get('index','VideoPlayback\admin\IndexController@index'); 
Route::get('login','VideoPlayback\admin\LoginController@login'); 
Route::any('do_login','VideoPlayback\admin\LoginController@do_login'); 
//分类
Route::get('cate_add','VideoPlayback\admin\CateController@cate_add'); //分类添加
Route::post('cate_add_do','VideoPlayback\admin\CateController@cate_add_do');
Route::get('cate_list','VideoPlayback\admin\CateController@cate_list');
Route::get('cate_del/{id}','VideoPlayback\admin\CateController@cate_del');
Route::get('cate_update/{id}','VideoPlayback\admin\CateController@cate_update');
Route::post('cate_update_do/{id}','VideoPlayback\admin\CateController@cate_update_do');

    /*
    公众号端
     */
//用户授权登录
Route::any('get_access_token','VideoPlayback\admin\WechatController@get_access_token');
Route::any('w_login','VideoPlayback\admin\WechatController@w_login');
Route::any('w_login_do','VideoPlayback\admin\WechatController@w_login_do');
Route::any('w_code','VideoPlayback\admin\WechatController@w_code');

/*七牛云*/
Route::any('qiniu','VideoPlayback\admin\WechatController@qiniu');
Route::any('qiniu_add','VideoPlayback\admin\WechatController@qiniu_add');



//素材
Route::any('upload_video','VideoPlayback\admin\WechatController@upload_video');
Route::any('do_upload','VideoPlayback\admin\WechatController@do_upload');
Route::any('get_access_token','VideoPlayback\admin\WechatController@access_token');

//自定义菜单

 Route::get('menu_list','VideoPlayback\admin\MenuController@menu_list');//自定义菜单列表
 Route::post('create_menu','VideoPlayback\admin\MenuController@create_menu');//创建自定义菜单
 Route::get('menu_del','VideoPlayback\admin\MenuController@menu_del');//删除菜单
 Route::get('load_menu','VideoPlayback\admin\MenuController@load_menu');//根据数据库表数据刷新菜单


/*小程序*/
    Route::prefix('mini')->group(function(){
    Route::get('nav/index','miniProgram\NavController@index');//电视剧导航栏
    Route::get('nav/lists','miniProgram\IndexController@lists');
    Route::get('nav/cha','miniProgram\IndexController@cha');

});





/*篮球直播*/   
    Route::get('index','talkroom\IndexController@index');







