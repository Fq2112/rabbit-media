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

Route::group(['namespace' => 'Pages\Admins', 'prefix' => 'admin', 'middleware' => 'rabbits'], function () {

    Route::get('/', [
        'middleware' => 'admin',
        'uses' => 'AdminController@index',
        'as' => 'home-admin'
    ]);

    Route::group(['prefix' => 'schedules'], function () {

        Route::get('/', [
            'uses' => 'AdminController@showSchedules',
            'as' => 'show.schedules'
        ]);

        Route::post('create', [
            'uses' => 'AdminController@createSchedules',
            'as' => 'create.schedules'
        ]);

        Route::put('update', [
            'uses' => 'AdminController@updateSchedules',
            'as' => 'update.schedules'
        ]);

        Route::delete('delete', [
            'uses' => 'AdminController@deleteSchedules',
            'as' => 'delete.schedules'
        ]);

    });

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

    Route::group(['prefix' => 'inbox', 'middleware' => 'admin'], function () {

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

        Route::group(['namespace' => 'DataMaster', 'middleware' => 'admin'], function () {

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

                    Route::post('deletes', [
                        'uses' => 'AccountsController@massDeleteAdmins',
                        'as' => 'massDelete.admins'
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

                    Route::post('deletes', [
                        'uses' => 'AccountsController@massDeleteUsers',
                        'as' => 'massDelete.users'
                    ]);

                });

            });

            Route::group(['prefix' => 'company-profile'], function () {

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

                    Route::post('deletes', [
                        'uses' => 'CompanyProfileController@massDeleteFaq',
                        'as' => 'massDelete.faqs'
                    ]);

                });

                Route::group(['prefix' => 'how-it-works'], function () {

                    Route::get('/', [
                        'uses' => 'CompanyProfileController@showHowItWorksTable',
                        'as' => 'table.howItWorks'
                    ]);

                    Route::post('create', [
                        'uses' => 'CompanyProfileController@createHowItWorks',
                        'as' => 'create.howItWorks'
                    ]);

                    Route::put('update', [
                        'uses' => 'CompanyProfileController@updateHowItWorks',
                        'as' => 'update.howItWorks'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'CompanyProfileController@deleteHowItWorks',
                        'as' => 'delete.howItWorks'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'CompanyProfileController@massDeleteHowItWorks',
                        'as' => 'massDelete.howItWorks'
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

                    Route::post('deletes', [
                        'uses' => 'CompanyProfileController@massDeletePortfolioTypes',
                        'as' => 'massDelete.portfolio-types'
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

                    Route::post('deletes', [
                        'uses' => 'CompanyProfileController@massDeletePortfolios',
                        'as' => 'massDelete.portfolios'
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

                    Route::post('deletes', [
                        'uses' => 'CompanyProfileController@massDeletePortfolioGalleries',
                        'as' => 'massDelete.portfolio-galleries'
                    ]);

                });

            });

            Route::group(['prefix' => 'features'], function () {

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

                    Route::post('deletes', [
                        'uses' => 'FeaturesController@massDeletePaymentCategories',
                        'as' => 'massDelete.PaymentCategories'
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

                    Route::post('deletes', [
                        'uses' => 'FeaturesController@massDeletePaymentMethods',
                        'as' => 'massDelete.PaymentMethods'
                    ]);

                });

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

                    Route::post('deletes', [
                        'uses' => 'FeaturesController@massDeleteServiceTypes',
                        'as' => 'massDelete.service-types'
                    ]);

                });

                Route::group(['prefix' => 'services'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showServicesTable',
                        'as' => 'table.services'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createServices',
                        'as' => 'create.services'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updateServices',
                        'as' => 'update.services'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deleteServices',
                        'as' => 'delete.services'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'FeaturesController@massDeleteServices',
                        'as' => 'massDelete.services'
                    ]);

                });

                Route::group(['prefix' => 'studio-types'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showStudioTypesTable',
                        'as' => 'table.studio-types'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createStudioTypes',
                        'as' => 'create.studio-types'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updateStudioTypes',
                        'as' => 'update.studio-types'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deleteStudioTypes',
                        'as' => 'delete.studio-types'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'FeaturesController@massDeleteStudioTypes',
                        'as' => 'massDelete.studio-types'
                    ]);

                });

                Route::group(['prefix' => 'studios'], function () {

                    Route::get('/', [
                        'uses' => 'FeaturesController@showStudiosTable',
                        'as' => 'table.studios'
                    ]);

                    Route::post('create', [
                        'uses' => 'FeaturesController@createStudios',
                        'as' => 'create.studios'
                    ]);

                    Route::put('update', [
                        'uses' => 'FeaturesController@updateStudios',
                        'as' => 'update.studios'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'FeaturesController@deleteStudios',
                        'as' => 'delete.studios'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'FeaturesController@massDeleteStudios',
                        'as' => 'massDelete.studios'
                    ]);

                });

            });

        });

        Route::group(['namespace' => 'DataTransaction'], function () {

            Route::group(['prefix' => 'clients', 'middleware' => 'admin'], function () {

                Route::group(['prefix' => 'feedback'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionClientController@showFeedbackTable',
                        'as' => 'table.feedback'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionClientController@deleteFeedback',
                        'as' => 'delete.feedback'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'TransactionClientController@massDeleteFeedback',
                        'as' => 'massDelete.feedback'
                    ]);

                });

                Route::group(['prefix' => 'orders'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionClientController@showOrdersTable',
                        'as' => 'table.orders'
                    ]);

                    Route::get('outcomes/{id}', [
                        'uses' => 'TransactionClientController@getOrderOutcomes',
                        'as' => 'get.order-outcomes'
                    ]);

                    Route::post('update', [
                        'uses' => 'TransactionClientController@updateOrders',
                        'as' => 'update.orders'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionClientController@deleteOrders',
                        'as' => 'delete.orders'
                    ]);

                    Route::post('net-incomes', [
                        'uses' => 'TransactionClientController@netIncomesOrders',
                        'as' => 'netIncomes.orders'
                    ]);

                    Route::post('recap', [
                        'uses' => 'TransactionClientController@recapOrders',
                        'as' => 'recap.orders'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'TransactionClientController@massDeleteOrders',
                        'as' => 'massDelete.orders'
                    ]);

                });

                Route::group(['prefix' => 'order-revisions'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionClientController@showOrderRevisionsTable',
                        'as' => 'table.order-revisions'
                    ]);

                    Route::post('deletes', [
                        'uses' => 'TransactionClientController@massDeleteOrderRevisions',
                        'as' => 'massDelete.order-revisions'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionClientController@deleteOrderRevisions',
                        'as' => 'delete.order-revisions'
                    ]);

                });

            });

            Route::group(['prefix' => 'staffs'], function () {

                Route::get('order/{id}', [
                    'uses' => 'TransactionStaffController@getOrders',
                    'as' => 'get.orders'
                ]);

                Route::group(['prefix' => 'order-logs', 'middleware' => 'staff'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionStaffController@showOrderLogsTable',
                        'as' => 'table.order-logs'
                    ]);

                    Route::post('create', [
                        'uses' => 'TransactionStaffController@createOrderLogs',
                        'as' => 'create.order-logs'
                    ]);

                    Route::put('update', [
                        'uses' => 'TransactionStaffController@updateOrderLogs',
                        'as' => 'update.order-logs'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionStaffController@deleteOrderLogs',
                        'as' => 'delete.order-logs'
                    ]);

                });

                Route::group(['prefix' => 'outcomes', 'middleware' => 'admin'], function () {

                    Route::group(['prefix' => 'orders'], function () {

                        Route::get('/', [
                            'uses' => 'TransactionStaffController@showOrderOutcomesTable',
                            'as' => 'table.order-outcomes'
                        ]);

                        Route::post('create', [
                            'uses' => 'TransactionStaffController@createOrderOutcomes',
                            'as' => 'create.order-outcomes'
                        ]);

                        Route::put('update', [
                            'uses' => 'TransactionStaffController@updateOrderOutcomes',
                            'as' => 'update.order-outcomes'
                        ]);

                        Route::post('massDelete', [
                            'uses' => 'TransactionStaffController@massDeleteOrderOutcomes',
                            'as' => 'massDelete.order-outcomes'
                        ]);

                        Route::get('{id}/delete', [
                            'uses' => 'TransactionStaffController@deleteOrderOutcomes',
                            'as' => 'delete.order-outcomes'
                        ]);

                    });

                    Route::group(['prefix' => 'non-orders'], function () {

                        Route::get('/', [
                            'uses' => 'TransactionStaffController@showNonOrderOutcomesTable',
                            'as' => 'table.nonOrder-outcomes'
                        ]);

                        Route::post('create', [
                            'uses' => 'TransactionStaffController@createNonOrderOutcomes',
                            'as' => 'create.nonOrder-outcomes'
                        ]);

                        Route::put('update', [
                            'uses' => 'TransactionStaffController@updateNonOrderOutcomes',
                            'as' => 'update.nonOrder-outcomes'
                        ]);

                        Route::post('massDelete', [
                            'uses' => 'TransactionStaffController@massDeleteNonOrderOutcomes',
                            'as' => 'massDelete.nonOrder-outcomes'
                        ]);

                        Route::get('{id}/delete', [
                            'uses' => 'TransactionStaffController@deleteNonOrderOutcomes',
                            'as' => 'delete.nonOrder-outcomes'
                        ]);

                    });

                });

            });

        });

    });

});
