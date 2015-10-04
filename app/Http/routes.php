<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/','PagesController@index');
Route::post('/','PostsController@store');
Route::get('contact','PagesController@contact');

Route::get('messages',[
    'middleware' => 'auth',
    'uses' => 'ConversationsController@index'
]);

Route::get('messages/{id}',[
    'middleware' => 'auth',
    'uses' => 'ConversationsController@getConversation'
]);
Route::post('messages/{id}',[
    'middleware' => 'auth',
    'uses' => 'MessagesController@store'
]);
Route::get('messages/{id}/debug',[
    'middleware' => 'auth',
    'uses' => 'ConversationsController@getUsersString'
]);

Route::get('user',[
    'middleware' => 'auth',
    'uses' => 'UsersController@index'
]);
Route::get('user/{id}',[
    'middleware' => 'auth',
    'uses' => 'UsersController@showUser'
]);
Route::post('user/{id}/invite',[
    'middleware' => 'auth',
    'uses' => 'UsersController@getAddFriend'
]);
Route::post('user/{id}/remove',[
    'middleware' => 'auth',
    'uses' => 'UsersController@getRemoveFriend'
]);
Route::post('user/{id}/accept',[
    'middleware' => 'auth',
    'uses' => 'UsersController@getConfirmFriend'
]);
Route::post('user/{id}/message',[
    'middleware' => 'auth',
    'uses' => 'MessagesController@createPrivate'
]);

Route::get('notifications/{id}/received',[
    'middleware' => 'auth',
    'uses' => 'NotificationsController@received'
]);

// Authentication routes...
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('post/{id}/edit','PostsController@edit');
Route::post('post/{id}/edit','PostsController@update');
Route::get('post/{id}',[
    'middleware' => 'auth',
    'uses' => 'PostsController@show'
]);
Route::post('post/{id}/destroy',[
    'middleware' => 'auth',
    'uses' => 'PostsController@destroy',
]);
Route::post('/post/{id}/upvote',[
    'middleware' => 'auth',
    'uses'       => 'PostsController@upvote'
]);
Route::post('/post/{id}/downvote',[
    'middleware' => 'auth',
    'uses'       => 'PostsController@downvote'
]);
Route::controllers([
    'password' => 'Auth\PasswordController',
]);
Route::post('/post/{id}/comments/add',[
    'middleware' => 'auth',
    'uses'       => 'CommentsController@store'
]);
Route::post('/notifications/viewAll',[
    'middleware' => 'auth',
    'uses'       => 'NotificationsController@viewAll'
]);