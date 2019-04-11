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

    Route::put('profile/update', [
        'uses' => 'AdminController@updateProfile',
        'as' => 'admin.update.profile'
    ]);

    Route::put('account/update', [
        'uses' => 'AdminController@updateAccount',
        'as' => 'admin.update.account'
    ]);

    Route::group(['prefix' => 'inbox'], function () {

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

            Route::group(['prefix' => 'accounts', 'middleware' => 'root'], function () {

                Route::group(['prefix' => 'admins'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showAdminsTable',
                        'as' => 'table.admins'
                    ]);

                    Route::post('create', [
                        'uses' => 'AccountsController@createAdmins',
                        'as' => 'create.admins'
                    ]);

                    Route::put('{id}/update/profile', [
                        'uses' => 'AccountsController@updateProfileAdmins',
                        'as' => 'update.profile.admins'
                    ]);

                    Route::put('{id}/update/account', [
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

            Route::group(['prefix' => 'web_contents', 'middleware' => 'root'], function () {

                Route::group(['prefix' => 'carousels'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showCarouselsTable',
                        'as' => 'table.carousels'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createCarousels',
                        'as' => 'create.carousels'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateCarousels',
                        'as' => 'update.carousels'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteCarousels',
                        'as' => 'delete.carousels'
                    ]);

                });

                Route::group(['prefix' => 'payment_categories'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPaymentCategoriesTable',
                        'as' => 'table.PaymentCategories'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPaymentCategories',
                        'as' => 'create.PaymentCategories'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePaymentCategories',
                        'as' => 'update.PaymentCategories'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePaymentCategories',
                        'as' => 'delete.PaymentCategories'
                    ]);

                });

                Route::group(['prefix' => 'payment_methods'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPaymentMethodsTable',
                        'as' => 'table.PaymentMethods'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPaymentMethods',
                        'as' => 'create.PaymentMethods'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePaymentMethods',
                        'as' => 'update.PaymentMethods'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePaymentMethods',
                        'as' => 'delete.PaymentMethods'
                    ]);

                });

                Route::group(['prefix' => 'plans'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPlansTable',
                        'as' => 'table.plans'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPlans',
                        'as' => 'create.plans'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePlans',
                        'as' => 'update.plans'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePlans',
                        'as' => 'delete.plans'
                    ]);

                });

                Route::group(['prefix' => 'nations'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showNationsTable',
                        'as' => 'table.nations'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createNations',
                        'as' => 'create.nations'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateNations',
                        'as' => 'update.nations'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteNations',
                        'as' => 'delete.nations'
                    ]);

                });

                Route::group(['prefix' => 'provinces'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showProvincesTable',
                        'as' => 'table.provinces'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createProvinces',
                        'as' => 'create.provinces'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateProvinces',
                        'as' => 'update.provinces'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteProvinces',
                        'as' => 'delete.provinces'
                    ]);

                });

                Route::group(['prefix' => 'cities'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showCitiesTable',
                        'as' => 'table.cities'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createCities',
                        'as' => 'create.cities'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateCities',
                        'as' => 'update.cities'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteCities',
                        'as' => 'delete.cities'
                    ]);

                });

                Route::group(['prefix' => 'blog'], function () {

                    Route::get('/', [
                        'uses' => 'BlogController@showBlogTable',
                        'as' => 'table.blog'
                    ]);

                    Route::post('create', [
                        'uses' => 'BlogController@createBlog',
                        'as' => 'create.blog'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'BlogController@updateBlog',
                        'as' => 'update.blog'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'BlogController@deleteBlog',
                        'as' => 'delete.blog'
                    ]);

                    Route::get('types', [
                        'uses' => 'BlogController@showBlogTypesTable',
                        'as' => 'table.blogTypes'
                    ]);

                    Route::post('types/create', [
                        'uses' => 'BlogController@createBlogTypes',
                        'as' => 'create.blogTypes'
                    ]);

                    Route::put('types/{id}/update', [
                        'uses' => 'BlogController@updateBlogTypes',
                        'as' => 'update.blogTypes'
                    ]);

                    Route::get('types/{id}/delete', [
                        'uses' => 'BlogController@deleteBlogTypes',
                        'as' => 'delete.blogTypes'
                    ]);

                });

            });

        });

        Route::group(['namespace' => 'DataTransaction'], function () {

            Route::group(['prefix' => 'agencies', 'middleware' => 'vacancy_staff'], function () {

                Route::group(['prefix' => 'vacancies'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionAgencyController@showVacanciesTable',
                        'as' => 'table.vacancies'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionAgencyController@deleteVacancies',
                        'as' => 'delete.vacancies'
                    ]);

                });

                Route::group(['prefix' => 'job_postings'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionAgencyController@showJobPostingsTable',
                        'as' => 'table.jobPostings'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'TransactionAgencyController@updateJobPostings',
                        'as' => 'table.jobPostings.update'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionAgencyController@deleteJobPostings',
                        'as' => 'table.jobPostings.delete'
                    ]);

                });

            });

        });

    });

});