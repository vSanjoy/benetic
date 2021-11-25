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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['namespace' => 'admin', 'prefix' => 'adminpanel', 'as' => 'admin.'], function () {
    Route::any('/', 'AuthController@login')->name('login');
    Route::any('/forget-password', 'AuthController@forgetPassword')->name('forget-password');
    Route::any('/reset-password/{token}', 'AuthController@resetPassword')->name('reset-password');
    Route::post('/ckeditor-upload', 'CmsController@upload')->name('ckeditor-upload');

    Route::group(['middleware' => 'backend'], function () {
        Route::any('/dashboard', 'AccountController@dashboard')->name('dashboard');
        Route::any('/edit-profile', 'AccountController@editProfile')->name('edit-profile');
        Route::any('/change-password', 'AccountController@changePassword')->name('change-password');
        Route::any('/logout', 'AuthController@logout')->name('logout');

        Route::group(['middleware' => 'admin'], function () {
            Route::any('/site-settings', 'AccountController@siteSettings')->name('site-settings');            
    
            // Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
            //     Route::get('/list/{type}', 'UsersController@list')->name('list');
            //     Route::post('list-request/{type}', 'UsersController@listRequest')->name('list-request');
            //     Route::get('/export/{type}', 'UsersController@exportAsCsv')->name('export');
            // });

            // Route::group(['prefix' => 'subAdmin', 'as' => 'subAdmin.'], function () {
            //     Route::get('/', 'SubAdminsController@list')->name('list');
            //     Route::post('list-request', 'SubAdminsController@listRequest')->name('list-request');
            //     Route::get('/add', 'SubAdminsController@add')->name('add');
            //     Route::post('/add-submit', 'SubAdminsController@add')->name('add-submit');
            //     Route::get('/edit/{id}', 'SubAdminsController@edit')->name('edit');
            //     Route::any('/edit-submit/{id}', 'SubAdminsController@edit')->name('edit-submit');
            //     Route::get('/status/{id}', 'SubAdminsController@status')->name('change-status');
            //     Route::get('/delete/{id}', 'SubAdminsController@delete')->name('delete');
            //     Route::post('/bulk-actions', 'SubAdminsController@bulkActions')->name('bulk-actions');
            // });

            // Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            //     Route::get('/', 'RolesController@list')->name('list');
            //     Route::post('list-request', 'RolesController@listRequest')->name('list-request');
            //     Route::get('/add', 'RolesController@add')->name('add');
            //     Route::post('/add-submit', 'RolesController@add')->name('add-submit');
            //     Route::get('/edit/{id}', 'RolesController@edit')->name('edit');
            //     Route::any('/edit-submit/{id}', 'RolesController@edit')->name('edit-submit');
            //     Route::get('/delete/{id}', 'RolesController@delete')->name('delete');
            //     Route::post('/bulk-actions', 'RolesController@bulkActions')->name('bulk-actions');
            // });

            Route::group(['prefix' => 'cms', 'as' => 'cms.'], function () {
                Route::get('/', 'CmsController@list')->name('list');
                Route::post('list-request', 'CmsController@listRequest')->name('list-request');
                Route::get('/edit/{id}', 'CmsController@edit')->name('edit');
                Route::post('/edit-submit/{id}', 'CmsController@edit')->name('edit-submit');
            });

            Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
                Route::get('/', 'BannerController@list')->name('list');
                Route::post('list-request', 'BannerController@listRequest')->name('list-request');
                Route::get('/add', 'BannerController@add')->name('add');
                Route::post('/add-submit', 'BannerController@add')->name('add-submit');            
                Route::get('/edit/{id}', 'BannerController@edit')->name('edit');
                Route::any('/edit-submit/{id}', 'BannerController@edit')->name('edit-submit');
                Route::get('/status/{id}', 'BannerController@status')->name('change-status');
                Route::get('/delete/{id}', 'BannerController@delete')->name('delete');
                Route::post('/bulk-actions', 'BannerController@bulkActions')->name('bulk-actions');
            });

            Route::group(['prefix' => 'logo', 'as' => 'logo.'], function () {
                Route::get('/', 'LogosController@list')->name('list');
                Route::post('list-request', 'LogosController@listRequest')->name('list-request');
                Route::get('/add', 'LogosController@add')->name('add');
                Route::post('/add-submit', 'LogosController@add')->name('add-submit');            
                Route::get('/edit/{id}', 'LogosController@edit')->name('edit');
                Route::any('/edit-submit/{id}', 'LogosController@edit')->name('edit-submit');
                Route::get('/status/{id}', 'LogosController@status')->name('change-status');
                Route::get('/delete/{id}', 'LogosController@delete')->name('delete');
                Route::post('/bulk-actions', 'LogosController@bulkActions')->name('bulk-actions');
            });

            Route::group(['prefix' => 'beneticTurn', 'as' => 'beneticTurn.'], function () {
                Route::get('/', 'BeneticTurnsController@list')->name('list');
                Route::post('list-request', 'BeneticTurnsController@listRequest')->name('list-request');
                Route::get('/add', 'BeneticTurnsController@add')->name('add');
                Route::post('/add-submit', 'BeneticTurnsController@add')->name('add-submit');            
                Route::get('/edit/{id}', 'BeneticTurnsController@edit')->name('edit');
                Route::any('/edit-submit/{id}', 'BeneticTurnsController@edit')->name('edit-submit');
                Route::get('/status/{id}', 'BeneticTurnsController@status')->name('change-status');
                Route::get('/delete/{id}', 'BeneticTurnsController@delete')->name('delete');
                Route::post('/bulk-actions', 'BeneticTurnsController@bulkActions')->name('bulk-actions');
            });

            Route::group(['prefix' => 'howItWork', 'as' => 'howItWork.'], function () {
                Route::get('/', 'HowItWorksController@list')->name('list');
                Route::post('list-request', 'HowItWorksController@listRequest')->name('list-request');
                Route::get('/add', 'HowItWorksController@add')->name('add');
                Route::post('/add-submit', 'HowItWorksController@add')->name('add-submit');            
                Route::get('/edit/{id}', 'HowItWorksController@edit')->name('edit');
                Route::any('/edit-submit/{id}', 'HowItWorksController@edit')->name('edit-submit');
                Route::get('/status/{id}', 'HowItWorksController@status')->name('change-status');
                Route::get('/delete/{id}', 'HowItWorksController@delete')->name('delete');
                Route::post('/bulk-actions', 'HowItWorksController@bulkActions')->name('bulk-actions');
            });

            Route::group(['prefix' => 'benefit', 'as' => 'benefit.'], function () {
                Route::get('/', 'BenefitsController@list')->name('list');
                Route::post('list-request', 'BenefitsController@listRequest')->name('list-request');
                Route::get('/add', 'BenefitsController@add')->name('add');
                Route::post('/add-submit', 'BenefitsController@add')->name('add-submit');            
                Route::get('/edit/{id}', 'BenefitsController@edit')->name('edit');
                Route::any('/edit-submit/{id}', 'BenefitsController@edit')->name('edit-submit');
                Route::get('/status/{id}', 'BenefitsController@status')->name('change-status');
                Route::get('/delete/{id}', 'BenefitsController@delete')->name('delete');
                Route::post('/bulk-actions', 'BenefitsController@bulkActions')->name('bulk-actions');
            });

            Route::group(['prefix' => 'teamMember', 'as' => 'teamMember.'], function () {
                Route::get('/', 'TeamMembersController@list')->name('list');
                Route::post('list-request', 'TeamMembersController@listRequest')->name('list-request');
                Route::get('/add', 'TeamMembersController@add')->name('add');
                Route::post('/add-submit', 'TeamMembersController@add')->name('add-submit');            
                Route::get('/edit/{id}', 'TeamMembersController@edit')->name('edit');
                Route::any('/edit-submit/{id}', 'TeamMembersController@edit')->name('edit-submit');
                Route::get('/status/{id}', 'TeamMembersController@status')->name('change-status');
                Route::get('/delete/{id}', 'TeamMembersController@delete')->name('delete');
                Route::post('/bulk-actions', 'TeamMembersController@bulkActions')->name('bulk-actions');
            });
            
        });

    });

});