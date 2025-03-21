<?php
use Illuminate\Support\Facades\Route;
Route::get('locked', 'UserController@viewLocked')->name("get.user.viewLocked");

Route::group([
    'middleware' => ["web", "admin"],
    "prefix" => "admin/",
],
    function () {
        Route::get('/', 'DashboardController@index')->name("get.home.index");
});

Route::group([
    'middleware' => ["web", "admin"],
    "namespace" => "Api",
    "prefix" => "admin/api",
],function () {
    Route::post('/upload', 'FileApiController@upload')->name("api.file.upload");
});

Route::group([
    'middleware' => ["user"],
    "prefix" => "/",
], function () {
    Route::group([
        "prefix" => "vote",
    ], function () {
        Route::post("/", 'VoteController@vote')->name("post.vote.vote");
        Route::post('delete', 'VoteController@delete')->name("post.vote.delete");
    });

    Route::group([
        "prefix" => "comment",
    ], function () {
        Route::post("/{blog_id}", 'CommentController@comment')->name("post.comment.comment");
        Route::delete('/{id}', 'CommentController@destroy')->name('delete.comments.destroy');
    });

    Route::group([
        "prefix" => "setting",
    ],
        function () {
            Route::get('my-profile', 'UserController@detail')->name("get.user.profile");
        });

    Route::post('updateUser', 'UserController@update')->name("get.user.update_user");
    Route::get('change-password', 'UserController@vChangePassword')->name("get.user.change_password");
    Route::post('change-password', 'UserController@pChangePassword')->name("post.user.change_password");
});




