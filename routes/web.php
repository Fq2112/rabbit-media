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

Route::post('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Auth::routes();

Route::group(['namespace' => 'Auth', 'prefix' => 'account'], function () {

    Route::post('login', [
        'uses' => 'LoginController@login',
        'as' => 'login'
    ]);

    Route::post('logout', [
        'uses' => 'LoginController@logout',
        'as' => 'logout'
    ]);

    Route::get('activate', [
        'uses' => 'ActivationController@activate',
        'as' => 'activate'
    ]);

    Route::get('login/{provider}', [
        'uses' => 'SocialAuthController@redirectToProvider',
        'as' => 'redirect'
    ]);

    Route::get('login/{provider}/callback', [
        'uses' => 'SocialAuthController@handleProviderCallback',
        'as' => 'callback'
    ]);

});

Route::group(['namespace' => 'Pages', 'prefix' => '/'], function () {

    Route::get('/', [
        'uses' => 'UserController@index',
        'as' => 'home'
    ]);

    Route::get('info', [
        'uses' => 'UserController@info',
        'as' => 'info'
    ]);

    Route::get('about', [
        'uses' => 'UserController@about',
        'as' => 'about'
    ]);

    Route::get('portfolio', [
        'uses' => 'UserController@portfolio',
        'as' => 'portfolio'
    ]);

    Route::get('order', [
        'uses' => 'UserController@order',
        'as' => 'order'
    ]);

    Route::get('order/{id}', [
        'uses' => 'UserController@orderid',
        'as' => 'order-id'
    ]);

    Route::get('service/{id}', [
        'uses' => 'UserController@detailService',
        'as' => 'detail.service'
    ]);

    Route::get('feedback', [
        'uses' => 'UserController@feedback',
        'as' => 'feedback'
    ]);

    Route::post('feedback', [
        'uses' => 'UserController@postFeedback',
        'as' => 'feedback.submit'
    ]);

    Route::get('contact', [
        'uses' => 'UserController@contact',
        'as' => 'contact'
    ]);

    Route::put('contact', [
        'uses' => 'MailController@postContact',
        'as' => 'contact.submit'
    ]);

    Route::post('order/save', [
        'uses' => 'UserController@postOrder',
        'as' => 'order.submit'
    ]);

});