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

Route::namespace('Pages')->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/news', 'NewsController@index')->name('news');
    Route::get('/news/{id}', 'NewsController@detail');
    Route::get('/about', 'AboutController@index')->name('about');
    Route::get('/activities', 'ActivitiesController@index')->name('activities');
    Route::get('/service', 'ServiceController@index')->name('service');
    Route::get('/joinUs', 'JoinUsController@index')->name('joinUs');
    Route::get('/traffic', 'TrafficController@index')->name('traffic');
    Route::get('/faq', 'FaqController@index')->name('faq');
    Route::get('/contact', 'ContactController@index')->name('contact');
    Route::post('/contact/store', 'ContactController@store')->name('contact.store');
    Route::get('/newsList', 'NewsController@list')->name('news.list');
    Route::get('/newsDetail/{id}', 'NewsController@getDetail')->name('news.detail');
    Route::get('/home/news', 'HomeController@homeNews')->name('home.homeNews');
});

// 驗證登入
Route::post('/signIn', function (Request $request) {
    $previous_url = Cookie::get('previous_url');
    if (isset($previous_url)) {
        return Redirect::to($previous_url);
    }
    return Redirect::route('index');
})->middleware('employee.signIn')->name('signIn');

Route::get('admin/login', function () {
    return view('admin.login');
})->name('login');

Route::namespace('Admin')->middleware('auth.employee')->group(function () {

    Route::group(['prefix' => 'admin'], function () {
        // 登出
        Route::get('/logout', function () {
            Adminer::signOut();
            return Redirect::route('login')->withCookie(Cookie::forget('previous_url'));
        })->name('logout');

        // dashboard
        Route::get('/', function () {
            return view('admin.index');
        })->name('index');
        // 帳號管理
        Route::group(['prefix' => 'employee', 'middleware' => ['acl.has:ACCOUNT_MANAGER']], function () {
            Route::get('/', 'EmployeeController@index')->name('employee.index');
            Route::get('/new', 'EmployeeController@new')->name('employee.new');
            Route::get('/edit/{id?}', 'EmployeeController@edit')->name('employee.edit');
            Route::post('/create', 'EmployeeController@create')->name('employee.create');
            Route::post('/update/{id}', 'EmployeeController@update')->name('employee.update');
        });

        // 最新消息發佈
        Route::group(['prefix' => 'news'], function () {
            Route::get('/', 'NewsController@index')->name('news.index');
            Route::get('/create', 'NewsController@create')->name('news.create');
            Route::get('/edit/{id}', 'NewsController@edit')->name('news.edit');
            Route::post('/store', 'NewsController@store')->name('news.store');
        });

        // 聯絡消息發佈
        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', 'ContactController@index')->name('contact.index');
        });
    });
});
