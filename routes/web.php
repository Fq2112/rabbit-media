<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Disini adalah routing untuk user Rabbit Media dengan middleware "web" .
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

Route::group(['namespace' => 'Pages\Admins', 'prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'AdminController@index',
        'as' => 'home-admin'
    ]);

    Route::group(['prefix' => 'account'], function () {

        Route::get('profile', [
            'uses' => 'AdminController@editProfile',
            'as' => 'admin.edit.profile'
        ]);

        Route::put('profile/update', [
            'uses' => 'AdminController@updateProfile',
            'as' => 'admin.update.profile'
        ]);

        Route::get('settings', [
            'uses' => 'AdminController@accountSettings',
            'as' => 'admin.settings'
        ]);

        Route::put('settings/update', [
            'uses' => 'AdminController@updateAccount',
            'as' => 'admin.update.account'
        ]);

    });

    Route::group(['prefix' => 'inbox', 'middleware' => 'inbox'], function () {

        Route::get('/', [
            'uses' => 'AdminController@showInbox',
            'as' => 'admin.inbox'
        ]);

        Route::post('compose', [
            'uses' => 'AdminController@composeInbox',
            'as' => 'admin.compose.inbox'
        ]);

        Route::get('{id}/delete', [
            'uses' => 'AdminController@deleteInbox',
            'as' => 'admin.delete.inbox'
        ]);

    });

    Route::group(['prefix' => 'tables'], function () {

        Route::group(['namespace' => 'DataMaster'], function () {

            Route::group(['prefix' => 'accounts'], function () {

                Route::group(['prefix' => 'admins'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showAdminsTable',
                        'as' => 'table.admins'
                    ]);

                    Route::post('create', [
                        'uses' => 'AccountsController@createAdmins',
                        'as' => 'create.admins'
                    ]);

                    Route::put('profile/update', [
                        'uses' => 'AccountsController@updateProfileAdmins',
                        'as' => 'update.profile.admins'
                    ]);

                    Route::put('account/update', [
                        'uses' => 'AccountsController@updateAccountAdmins',
                        'as' => 'update.account.admins'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteAdmins',
                        'as' => 'delete.admins'
                    ]);

                });

                Route::group(['prefix' => 'users'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showUsersTable',
                        'as' => 'table.users'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteUsers',
                        'as' => 'delete.users'
                    ]);

                });

            });

            Route::group(['prefix' => 'company-profile', 'middleware' => 'inbox'], function () {

                Route::get('/', [
                    'uses' => 'CompanyProfileController@showCompanyProfile',
                    'as' => 'show.company.profile'
                ]);

                Route::put('update', [
                    'uses' => 'CompanyProfileController@updateCompanyProfile',
                    'as' => 'update.company.profile'
                ]);

                Route::group(['prefix' => 'faqs'], function () {

                    Route::get('/', [
                        'uses' => 'CompanyProfileController@showFaqTable',
                        'as' => 'table.faqs'
                    ]);

                    Route::post('create', [
                        'uses' => 'CompanyProfileController@createFaq',
                        'as' => 'create.faqs'
                    ]);

                    Route::put('update', [
                        'uses' => 'CompanyProfileController@updateFaq',
                        'as' => 'update.faqs'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'CompanyProfileController@deleteFaq',
                        'as' => 'delete.faqs'
                    ]);

                });

                Route::group(['prefix' => 'portfolio-types'], function () {

                    Route::get('/', [
                        'uses' => 'CompanyProfileController@showPortfolioTypesTable',
                        'as' => 'table.portfolio-types'
                    ]);

                    Route::post('create', [
                        'uses' => 'CompanyProfileController@createPortfolioTypes',
                        'as' => 'create.portfolio-types'
                    ]);

                    Route::put('update', [
                        'uses' => 'CompanyProfileController@updatePortfolioTypes',
                        'as' => 'update.portfolio-types'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'CompanyProfileController@deletePortfolioTypes',
                        'as' => 'delete.portfolio-types'
                    ]);

                });

                Route::group(['prefix' => 'portfolios'], function () {

                    Route::get('/', [
                        'uses' => 'CompanyProfileController@showPortfoliosTable',
                        'as' => 'table.portfolios'
                    ]);

                    Route::post('create', [
                        'uses' => 'CompanyProfileController@createPortfolios',
                        'as' => 'create.portfolios'
                    ]);

                    Route::put('update', [
                        'uses' => 'CompanyProfileController@updatePortfolios',
                        'as' => 'update.portfolios'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'CompanyProfileController@deletePortfolios',
                        'as' => 'delete.portfolios'
                    ]);

                });

                Route::group(['prefix' => 'portfolio-galleries'], function () {

                    Route::get('/', [
                        'uses' => 'CompanyProfileController@showPortfolioGalleriesTable',
                        'as' => 'table.portfolio-galleries'
                    ]);

                    Route::post('create', [
                        'uses' => 'CompanyProfileController@createPortfolioGalleries',
                        'as' => 'create.portfolio-galleries'
                    ]);

                    Route::put('update', [
                        'uses' => 'CompanyProfileController@updatePortfolioGalleries',
                        'as' => 'update.portfolio-galleries'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'CompanyProfileController@deletePortfolioGalleries',
                        'as' => 'delete.portfolio-galleries'
                    ]);

                });

            });

            Route::group(['prefix' => 'features', 'middleware' => 'root'], function () {

                Route::group(['prefix' => 'service-types'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showServiceTypesTable',
                        'as' => 'table.service-types'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createServiceTypes',
                        'as' => 'create.service-types'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updateServiceTypes',
                        'as' => 'update.service-types'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deleteServiceTypes',
                        'as' => 'delete.service-types'
                    ]);

                });

                Route::group(['prefix' => 'service-pricing'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showServicePricingTable',
                        'as' => 'table.service-pricing'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createServicePricing',
                        'as' => 'create.service-pricing'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updateServicePricing',
                        'as' => 'update.service-pricing'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deleteServicePricing',
                        'as' => 'delete.service-pricing'
                    ]);

                });

                Route::group(['prefix' => 'payment-categories'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showPaymentCategoriesTable',
                        'as' => 'table.PaymentCategories'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createPaymentCategories',
                        'as' => 'create.PaymentCategories'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updatePaymentCategories',
                        'as' => 'update.PaymentCategories'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deletePaymentCategories',
                        'as' => 'delete.PaymentCategories'
                    ]);

                });

                Route::group(['prefix' => 'payment-methods'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showPaymentMethodsTable',
                        'as' => 'table.PaymentMethods'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createPaymentMethods',
                        'as' => 'create.PaymentMethods'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updatePaymentMethods',
                        'as' => 'update.PaymentMethods'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deletePaymentMethods',
                        'as' => 'delete.PaymentMethods'
                    ]);

                });

            });

        });

        Route::group(['namespace' => 'DataTransaction'], function () {

            Route::group(['prefix' => 'clients'], function () {

                Route::group(['prefix' => 'feedback'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionClientController@showFeedbackTable',
                        'as' => 'table.feedback'
                    ]);

                    Route::put('update', [
                        'uses' => 'TransactionClientController@updateFeedback',
                        'as' => 'table.feedback.update'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionClientController@deleteFeedback',
                        'as' => 'table.feedback.delete'
                    ]);

                });

                Route::group(['prefix' => 'orders'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionClientController@showOrdersTable',
                        'as' => 'table.orders'
                    ]);

                    Route::put('update', [
                        'uses' => 'TransactionClientController@updateOrders',
                        'as' => 'table.orders.update'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionClientController@deleteOrders',
                        'as' => 'table.orders.delete'
                    ]);

                });

            });

        });

    });

});