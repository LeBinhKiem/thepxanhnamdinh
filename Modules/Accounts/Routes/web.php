<?php
use Illuminate\Support\Facades\Route;

    Route::group([
        'middleware' => ["admin"],
        "prefix" => "accounts",
    ], function () {

        Route::prefix("admin/config")->group(function () {
        Route::get('/', 'AdminController@index')->name("get.admin.index");
        Route::get('setting', 'AdminController@setting')->name("get.admin.setting");
        Route::post('update', 'AdminController@update')->name("post.admin.update");
        Route::post('updateLogo', 'AdminController@updateLogo')->name("post.admin.updateLogo");
        Route::post('updatePasswordMyAccount', 'AdminController@updatePasswordMyAccount')->name("post.admin.updatePasswordMyAccount");
        
        Route::group([
            'middleware' => ["super-admin"],
        ], function () {
            Route::get('create', 'AdminController@create')->name("get.admin.create");
            Route::post('store', 'AdminController@store')->name("post.admin.store");
            Route::get('edit/{id}', 'AdminController@edit')->name("get.admin.edit");
            Route::post('updateRegister', 'AdminController@updateRegister')->name("post.admin.updateRegister");
            Route::get('updatePassword/{id}', 'AdminController@updatePassword')->name("get.admin.updatePassword");
            Route::post('updatePasswordBySuperAdmin', 'AdminController@updatePasswordBySuperAdmin')->name("post.admin.updatePasswordBySuperAdmin");
        });
    });

    Route::prefix("admin/user")->group(function () {
        Route::get('/', 'UserController@index')->name("get.user.index");
        Route::post('lock', 'UserController@lock')->name("post.user.lock");
        Route::post('unLock', 'UserController@unLock')->name("post.user.unLock");
    });
});

