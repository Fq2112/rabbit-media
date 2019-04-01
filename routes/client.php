<?php

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Disini adalah routing untuk client Rabbit Media dengan middleware "web" .
|
*/

Route::group(['namespace' => 'Pages', 'prefix' => '/'], function () {

    Route::get('/', [
        'uses' => 'UserController@index',
        'as' => 'home'
    ]);

    Route::group(['prefix' => 'portfolios'], function () {

        Route::get('/', [
            'uses' => 'UserController@showPortfolio',
            'as' => 'show.portfolio'
        ]);

        Route::get('{jenis}/{id}', [
            'uses' => 'UserController@showPortfolioGalleries',
            'as' => 'show.portfolio.gallery'
        ]);

    });

    Route::get('info', [
        'uses' => 'UserController@info',
        'as' => 'info'
    ]);

    Route::get('about', [
        'uses' => 'UserController@about',
        'as' => 'about'
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