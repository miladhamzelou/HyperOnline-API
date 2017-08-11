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

Route::auth();

Route::get('/', 'IdeaController@index')->name('home');

Route::get('/home', 'IdeaController@index')->name('home');

Route::get('/profile', function () {
    return View::make('profile');
})->name('profile');

Route::group(['middleware' => ['auth']], function () {
    // show new post form
    Route::get('new-idea', 'IdeaController@create');
    // save new post
    Route::post('new-idea', 'IdeaController@store');
    // edit post form
    Route::get('edit/{id}', 'IdeaController@edit');
    // update post
    Route::post('update', 'IdeaController@update');
    // delete post
    Route::get('delete/{id}', 'IdeaController@destroy');
});

//users profile
Route::get('user/{id}', 'UserController@profile')->where('id', '[0-9]+');
// display list of posts
Route::get('user/{id}/ideas', 'UserController@user_posts')->where('id', '[0-9]+');
// display single post
Route::get('/{slug}', ['as' => 'post', 'uses' => 'IdeaController@show'])->where('slug', '[A-Za-z0-9-_]+');

Route::post('like', 'IdeaController@like');
Route::post('dislike', 'IdeaController@dislike');

