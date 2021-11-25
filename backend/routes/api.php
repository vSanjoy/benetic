<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
    Route::group(['middleware' => 'api'], function () {
        Route::get('/', 'HomeController@index')->name('api_index');

        // Home page section
        Route::group(['prefix' => 'home'], function () {
            Route::any('/home-page-details', 'HomeController@homePageDetails')->name('api_home_page_details');
        });
        // Platform page section
        Route::group(['prefix' => 'platform'], function () {
            Route::any('/platform-page-details', 'HomeController@platformPageDetails')->name('api_platform_page_details');
        });
        // Advisors page section
        Route::group(['prefix' => 'advisors'], function () {
            Route::any('/advisors-page-details', 'HomeController@advisorsPageDetails')->name('api_advisors_page_details');
        });
        // Recordkeeper page section
        Route::group(['prefix' => 'recordkeeper'], function () {
            Route::any('/recordkeeper-page-details', 'HomeController@recordkeeperPageDetails')->name('api_recordkeeper_page_details');
        });
        // Asset Managers page section
        Route::group(['prefix' => 'asset-managers'], function () {
            Route::any('/asset-managers-page-details', 'HomeController@assetManagersPageDetails')->name('api_asset_managers_page_details');
        });
        // About us page section
        Route::group(['prefix' => 'about-us'], function () {
            Route::any('/about-page-details', 'HomeController@aboutPageDetails')->name('api_about_page_details');
        });
        // Sign up section
        Route::group(['prefix' => 'capture'], function () {
            Route::post('/registration', 'HomeController@registration')->name('api_pop_up_registration');
        });
        // Footer section
        Route::group(['prefix' => 'footer'], function () {
            Route::any('/footer-details', 'HomeController@footerDetails')->name('api_footer_details');
        });
    });
});