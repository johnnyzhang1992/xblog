<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
// User Auth
Route::group(['middleware' => 'web'], function () {
    Auth::routes();
    Route::get('/auth/github', ['uses' => 'Auth\AuthController@redirectToGithub', 'as' => 'github.login']);
    Route::get('/auth/github/callback', ['uses' => 'Auth\AuthController@handleGithubCallback', 'as' => 'github.callback']);
    Route::get('/github/register',['uses' => 'Auth\AuthController@registerFromGithub', 'as' => 'github.register']);
    Route::post('/github/store',['uses' => 'Auth\AuthController@store', 'as' => 'github.store']);

// Site route
//    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'index']);
    Route::get('/', ['uses' => 'PostController@index', 'as' => 'index']);
    Route::get('/projects', ['uses' => 'HomeController@projects', 'as' => 'projects']);
    Route::get('/search', ['uses' => 'HomeController@search', 'as' => 'search']);
    Route::get('/achieve', ['uses' => 'HomeController@achieve', 'as' => 'achieve']);

// Post
    Route::get('/blog', ['uses' => 'PostController@index', 'as' => 'post.index']);
    Route::get('/blog/{slug}', ['uses' => 'PostController@show', 'as' => 'post.show']);

// Category
    Route::get('/category/{name}', ['uses' => 'CategoryController@show', 'as' => 'category.show']);
    Route::get('/category', ['uses' => 'CategoryController@index', 'as' => 'category.index']);

// Tag
    Route::get('/tag/{name}', ['uses' => 'TagController@show', 'as' => 'tag.show']);
    Route::get('/tag', ['uses' => 'TagController@index', 'as' => 'tag.index']);

// User
    Route::get('/user/{name}', ['uses' => 'UserController@show', 'as' => 'user.show']);
    Route::get('/notifications', ['uses' => 'UserController@notifications', 'as' => 'user.notifications']);
    Route::patch('/user/upload/avatar', ['uses' => 'UserController@uploadAvatar', 'as' => 'user.upload.avatar']);
    Route::patch('/user/upload/profile', ['uses' => 'UserController@uploadProfile', 'as' => 'user.upload.profile']);
    Route::patch('/user/upload/info', ['uses' => 'UserController@update', 'as' => 'user.update.info']);

// Comment
    Route::get('/commentable/{commentable_id}/comments', ['uses' => 'CommentController@show', 'as' => 'comment.show']);
    Route::resource('comment', 'CommentController', ['only' => ['store', 'destroy', 'edit', 'update']]);


// SiteMap
    Route::get('sitemap','SiteMapController@index');
    Route::get('sitemap.xml','SiteMapController@index');
//  travel
    Route::group(['prefix' => 'travel'],function (){
        Route::get('/','TravelController@index');
        Route::get('/get_data','TravelController@get_data');
        Route::get('/poi/{id}','TravelController@detail')->where('id', '[0-9]+');
        Route::post('/poi/{id}/update','TravelController@detail_update');
        /**
         * poi
         */
        Route::post('/poi/publish/{id}','TravelController@publish')->where('id', '[0-9]+');
        Route::post('/poi/edit/{id}','TravelController@edit')->where('id', '[0-9]+');
        Route::post('/poi/restore/{id}','TravelController@restore')->where('id', '[0-9]+');
        Route::post('/poi/destroy/{id}','TravelController@destroy')->where('id', '[0-9]+');
        /**
         * comment
         */
    });
    Route::group(['prefix' => 'book'],function (){
       Route::get('/','BookController@index');
       Route::get('/{id}','BookController@detail');
       Route::post('{id}/update','BookController@update');
    });

});

/* 上传文件 */
Route::group([
    'prefix' => 'upload',
    'middleware' => ['auth','admin']
],function (){
    Route::match(['GET', 'POST'],'/local-image','ImageController@uploadImageByAjax');

});

Route::group(['prefix' => 'admin', ['middleware' => ['auth', 'admin']]], function () {

    /**
     * admin url
     */
    Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
    Route::get('/settings', ['uses' => 'AdminController@settings', 'as' => 'admin.settings']);
    Route::post('/settings', ['uses' => 'AdminController@saveSettings', 'as' => 'admin.save-settings']);
    Route::post('/upload/image', ['uses' => 'ImageController@uploadImage', 'as' => 'upload.image']);
    Route::post('/upload/image/local', ['uses' => 'ImageController@uploadImageToLocal', 'as' => 'upload.image.local']);
    Route::delete('/delete/file', ['uses' => 'FileController@deleteFile', 'as' => 'delete.file']);
    Route::delete('/delete/local_file', ['uses' => 'FileController@deleteLocalFile', 'as' => 'delete.local_file']);
    Route::post('/upload/file', ['uses' => 'FileController@uploadFile', 'as' => 'upload.file']);


    /**
     * admin uri
     */
    Route::get('/posts', ['uses' => 'AdminController@posts', 'as' => 'admin.posts']);
    Route::get('/comments', ['uses' => 'AdminController@comments', 'as' => 'admin.comments']);
    Route::get('/tags', ['uses' => 'AdminController@tags', 'as' => 'admin.tags']);
    Route::get('/users', ['uses' => 'AdminController@users', 'as' => 'admin.users']);
    Route::get('/pages', ['uses' => 'AdminController@pages', 'as' => 'admin.pages']);
    Route::get('/categories', ['uses' => 'AdminController@categories', 'as' => 'admin.categories']);
    Route::get('/images', ['uses' => 'ImageController@images', 'as' => 'admin.images']);
    Route::get('/files', ['uses' => 'FileController@files', 'as' => 'admin.files']);
    Route::get('/pois', ['uses' => 'AdminController@pois', 'as' => 'admin.pois']);
    Route::get('/books', ['uses' => 'AdminController@books', 'as' => 'admin.books']);
    Route::get('/visitors', ['uses' => 'VisitorController@visitors', 'as' => 'admin.visitors']);
//    Route::get('/students', ['uses' => 'AdminController@students', 'as' => 'admin.students']);

    /**
     * comment
     */
    Route::post('/comment/{comment}/restore', ['uses' => 'CommentController@restore', 'as' => 'comment.restore']);

    /***
     * post
     */

    Route::post('/post/{post}/restore', ['uses' => 'PostController@restore', 'as' => 'post.restore']);
    Route::get('/post/{slug}/preview', ['uses' => 'PostController@preview', 'as' => 'post.preview']);
    Route::post('/post/{post}/publish', ['uses' => 'PostController@publish', 'as' => 'post.publish']);


    /**
     * poi
     */
    Route::post('/poi/publish/{id}','TravelController@publish')->where('id', '[0-9]+');
    Route::get('/poi/edit/{id}','TravelController@edit')->where('id', '[0-9]+');
    Route::post('/poi/restore/{id}','TravelController@restore')->where('id', '[0-9]+');
    Route::get('/poi/destroy/{id}','TravelController@destroy')->where('id', '[0-9]+');
    Route::get('/poi/create_new',function (){return view('travel.create');});
    Route::post('/poi/create','TravelController@create');
    Route::post('/travel/upload/image', ['uses' => 'ImageController@uploadImageToTravel', 'as' => 'travel.upload.images']);
    Route::post('/travel/upload/cover_image', ['uses' => 'ImageController@uploadTravelCoverImage', 'as' => 'travel.upload.cover_image']);


    /**
     * books
     */

    Route::post('/book/publish/{id}','BookController@publish')->where('id', '[0-9]+');
    Route::get('/book/edit/{id}','BookController@edit')->where('id', '[0-9]+');
    Route::post('/book/restore/{id}','BookController@restore')->where('id', '[0-9]+');
    Route::get('/book/destroy/{id}','BookController@destroy')->where('id', '[0-9]+');
    Route::get('/book/create_new',function (){return view('book.create');});
    Route::post('/book/create','BookController@create');
    Route::post('/book/upload/cover_image', ['uses' => 'ImageController@uploadBookCoverImage', 'as' => 'book.upload.cover_image']);

    /**
     * tag
     */
    Route::delete('/tag/{tag}', ['uses' => 'TagController@destroy', 'as' => 'tag.destroy']);
    Route::post('/tag', ['uses' => 'TagController@store', 'as' => 'tag.store']);

    /**
     * admin resource
     */
    Route::resource('post', 'PostController', ['except' => ['show', 'index']]);
    Route::resource('category', 'CategoryController', ['except' => ['index', 'show', 'create']]);
    Route::resource('page', 'PageController', ['except' => ['show', 'index']]);

    /**
     * students
     */
//    Route::post('/student/create','StudentController@create');
//    Route::post('/student/edit','StudentController@edit');
//    Route::post('/student/delete','StudentController@delete');
//    Route::post('/student/restore/{id}','StudentController@restore');
//    Route::get('/student/excel','StudentController@excel');
    /**
     * excel 导出数据库信息
     */
//    Route::get('/excel/books','ExcelController@books');
//    Route::get('/excel/categories','ExcelController@categories');
//    Route::get('/excel/comments','ExcelController@comments');
//    Route::get('/excel/configurations','ExcelController@configurations');
//    Route::get('/excel/files','ExcelController@files');
//    Route::get('/excel/maps','ExcelController@maps');
//    Route::get('/excel/pages','ExcelController@pages');
//    Route::get('/excel/pois','ExcelController@pois');
//    Route::get('/excel/sports','ExcelController@sports');
//    Route::get('/excel/posts','ExcelController@posts');
//    Route::get('/excel/post_tag','ExcelController@post_tag');
//    Route::get('/excel/tags','ExcelController@tags');
//    Route::get('/excel/travel','ExcelController@travel');
//    Route::get('/excel/travel_files','ExcelController@travel_files');
//    Route::get('/excel/users','ExcelController@users');
});
/*
 * must last
 * use page slug
 */
/*  */
Route::group([
    'prefix' => 'excel',
    'middleware' => ['auth','admin']
],function (){
    Route::get('/export','ExcelController@export');
    Route::get('/import','ExcelController@import');
});
/*
 * google map
 */
Route::group(['prefix' => 'map'],function (){
    Route::get('/','MapController@index');
});
/*
 * 微信小程序
 */
Route::group(['prefix' => 'wxxcx'],function (){
    Route::match(['GET', 'POST'],'/userinfo','WxxcxController@getWxUserInfo');
    Route::get('/rundata','WxxcxController@getWxUserRunData');
    Route::get('/run','WxxcxController@WxUserRunData');
    Route::get('/userinfo/{id}','WxxcxController@getUserInfo');
    /*
     * 个人信息设置部分
     */
    Route::get('/get/user_count','WxxcxController@userCount');
    Route::get('/set/name','WxxcxController@updateName');
    Route::get('/set/address','WxxcxController@updateAddress');
    Route::get('/set/signature','WxxcxController@updateSignature');
    /*
     * 阅读部分
     */
    Route::get('/get/book','WxxcxController@getBook');
    Route::get('/delete/book','WxxcxController@deleteBook');
    Route::get('/get/user_book','WxxcxController@getUserAllBook');
    Route::get('/save/book','WxxcxController@createBook');
    Route::get('/get/book_detail','WxxcxController@getBookDetail');
    /*
     * posts
     */
    Route::get('/get/posts','WxxcxController@getPosts');
    Route::get('/delete/post','WxxcxController@deletePost');
    Route::get('/get/user_posts','WxxcxController@getUserAllPosts');
    Route::get('/save/post','WxxcxController@savePost');
    /*
     * poi
     */
    Route::get('/get/post_detail','WxxcxController@getPostDetail');
    Route::get('/get/pois','WxxcxController@getPois');
    Route::get('/save/poi','WxxcxController@savePoi');
    Route::get('/delete/poi','WxxcxController@deletePoi');
    Route::get('/get/user_pois','WxxcxController@getUserAllPois');
    Route::get('/get/poi_detail','WxxcxController@getPoiDetail');
    /*
     * diary
     */
    Route::get('/save/diary','WxxcxController@saveDiary');
    Route::get('/get/diarys','WxxcxController@getDiary');
    Route::get('/get/diary_detail','WxxcxController@getDiaryDetail');
    Route::get('/delete/diary','WxxcxController@deleteDiary');
    Route::get('/get/user_diarys','WxxcxController@getUserAllDiarys');
    /*
     * comment
     */
    Route::get('/get/comments','WxxcxController@getComments');
    Route::get('/save/comment','WxxcxController@saveComment');
    Route::get('/delete/comment','WxxcxController@deleteComment');

    /*
     * 上传图片
     */
//    Route::post('/poi/upload/cover_image', 'ImageController@uploadTravelCoverImage');
    Route::post('/poi/upload/cover_image', 'ImageController@uploadImageByWx');
    Route::get('/qiniu/uptoken','WxxcxController@getUploadToken');
    /*
     * 管理员
     */
    Route::get('/get/users','WxxcxController@getUsers');
});


Route::get('/{name}', ['uses' => 'PageController@show', 'as' => 'page.show']);