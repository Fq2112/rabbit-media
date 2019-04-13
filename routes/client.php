<?php

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Disini adalah routing untuk client Rabbit Media dengan middleware "web" .
|
*/
Route::get('test', function () {
    return view('pages.clients.invoice');
});

Route::group(['namespace' => 'Pages', 'prefix' => '/'], function () {

    Route::get('/', [
        'uses' => 'UserController@index',
        'as' => 'home'
    ]);

    Route::get('about', [
        'uses' => 'UserController@about',
        'as' => 'about'
    ]);

    Route::post('contact', [
        'uses' => 'UserController@postContact',
        'as' => 'submit.contact'
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

        Route::group(['prefix' => 'order', 'namespace' => 'Client'], function () {

            Route::get('{id}', [
                'uses' => 'OrderController@showOrder',
                'as' => 'show.order'
            ]);

            Route::get('reviewData/pricing/{pricing}', [
                'uses' => 'OrderController@getPricingReviewData',
                'as' => 'get.pricingReviewData'
            ]);

            Route::get('paymentMethod/{id}', [
                'uses' => 'OrderController@getPaymentMethod',
                'as' => 'get.paymentMethod'
            ]);

            Route::post('submit', [
                'uses' => 'OrderController@submitOrder',
                'as' => 'submit.order'
            ]);

            Route::put('payment-proof/submit', [
                'uses' => 'OrderController@uploadPaymentProof',
                'as' => 'upload.paymentProof'
            ]);

            Route::get('invoice/{id}', [
                'uses' => 'OrderController@invoiceOrder',
                'as' => 'invoice.order'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'OrderController@deleteOrder',
                'as' => 'delete.order'
            ]);

        });

    });

    Route::group(['prefix' => 'feedback'], function () {

        Route::get('/', [
            'uses' => 'UserController@feedback',
            'as' => 'feedback'
        ]);

        Route::post('submit', [
            'middleware' => 'auth',
            'uses' => 'UserController@postFeedback',
            'as' => 'feedback.submit'
        ]);

        Route::get('{id}/delete', [
            'middleware' => 'auth',
            'uses' => 'UserController@deleteFeedback',
            'as' => 'feedback.delete'
        ]);

    });

    Route::group(['prefix' => 'account', 'namespace' => 'Client'], function () {

        Route::get('profile', [
            'uses' => 'AccountController@editProfile',
            'as' => 'client.edit.profile'
        ]);

        Route::put('profile/update', [
            'uses' => 'AccountController@updateProfile',
            'as' => 'client.update.profile'
        ]);

        Route::get('settings', [
            'uses' => 'AccountController@accountSettings',
            'as' => 'client.settings'
        ]);

        Route::put('settings/update', [
            'uses' => 'AccountController@updateAccount',
            'as' => 'client.update.settings'
        ]);

        Route::group(['prefix' => 'dashboard'], function () {

            Route::get('order-status', [
                'uses' => 'OrderController@showDashboard',
                'as' => 'client.dashboard'
            ]);

            Route::get('data', [
                'uses' => 'OrderController@getOrderStatus',
                'as' => 'get.client.orderStatus'
            ]);

        });

    });

});