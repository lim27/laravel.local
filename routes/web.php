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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', 'PostController')-> names('blog.posts');
});

Route::resource('rest', 'RestTestController') -> names('restTest');


#Админка Блога
$groupData = [
    'namespace' => 'Blog\Admin',
    'prefix'    => 'admin/blog',
];
Route::group($groupData, function () {
    //Blog Category
    $method = ['index', 'edit', 'store', 'update', 'create',];

    Route::resource('categories', 'CategoryController')
        ->only($method)
        ->names('blog.admin.categories');
});


