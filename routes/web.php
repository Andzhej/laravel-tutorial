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
/* Examples

//pass some parameters to url
Route::get('/users/{id}/{name}', function ($id, $name) {
    return $id.'and name is '.$name;
});

//simple html return
Route::get('/hello', function () {
    return <h1>Hello world</h1>;
});

*/

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController');
Auth::routes();

Route::get('/posts/continent/{category_id}', 'PostsController@continent');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/search', 'HomeController@search');

//User
Route::get('user/user-profile', 'UserController@index');
Route::post('user/{user_id}/user-profile', 'UserController@update');
Route::get('user/{user_id}/user-posts', 'UserController@get_user_posts');