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

    Route::get('info', [
        'uses' => 'UserController@info',
        'as' => 'info'
    ]);

    Route::get('faq', [
        'uses' => 'UserController@faq',
        'as' => 'faq'
    ]);

    Route::group(['prefix' => 'portfolios'], function () {

        Route::get('/', [
            'uses' => 'UserController@showPortfolio',
            'as' => 'show.portfolio'
        ]);

        Route::get('data', [
            'uses' => 'UserController@getPortfolios',
            'as' => 'get.portfolios'
        ]);

        Route::get('{jenis}/{id}/galleries', [
            'uses' => 'UserController@showPortfolioGalleries',
            'as' => 'show.portfolio.gallery'
        ]);

    });

    Route::group(['prefix' => 'services'], function () {

        Route::get('/', [
            'uses' => 'UserController@showService',
            'as' => 'show.service'
        ]);

        Route::get('{jenis}/{id}/pricing', [
            'uses' => 'UserController@showServicePricing',
            'as' => 'show.service.pricing'
        ]);

    });

    Route::get('about', [
        'uses' => 'UserController@about',
        'as' => 'about'
    ]);

    Route::get('feedback', [
        'uses' => 'UserController@feedback',
        'as' => 'feedback'
    ]);

    Route::post('feedback', [
        'uses' => 'UserController@postFeedback',
        'as' => 'feedback.submit'
    ]);

});