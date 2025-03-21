<?php
use Illuminate\Support\Facades\Route;
// Auth
Route::prefix('admin/auth')->group(function () {
    Route::get('/login', 'AuthAdminController@vLogin')->name("get.auth.login");
    Route::post('/login', 'AuthAdminController@pLogin')->name("post.auth.login");
    Route::get('/register', 'AuthAdminController@vRegister')->name("get.auth.register");
    Route::get('/logout', 'AuthAdminController@logout')->name("get.auth.logout")->middleware('admin');
    Route::get('/forget-password', 'AuthAdminController@vForgetPassword')->name("get.auth.forget_password");
    Route::post('/forget-password', 'AuthAdminController@pForgetPassword')->name("post.auth.forget_password");
});


Route::prefix('auth')->group(function () {
    Route::get('/login', 'AuthUserController@vLogin')->name("get.auth_user.login");
    Route::post('/login', 'AuthUserController@pLogin')->name("post.auth_user.login");
    Route::get('/logout', 'AuthUserController@logout')->middleware(['web'])->name("get.auth_user.logout");
    Route::get('/register', 'AuthUserController@vRegister')->name("get.auth_user.register");
    Route::post('/register', 'AuthUserController@pRegister')->name("post.auth_user.register");
    Route::get('/forget-password', 'AuthUserController@vForgetPassword')->name("get.auth_user.forget_password");
    Route::post('/forget-password', 'AuthUserController@pForgetPassword')->name("post.auth_user.forget_password");
});
