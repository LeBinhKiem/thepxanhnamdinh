<?php
use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function () {
    Route::get('/', 'HomeController@index')->name("get.sell.index");
    Route::get('detail/{id}', 'SellController@detail')->name("get.sell.detail");
    Route::get('store', 'SellController@search')->name("get.sell.search");
    Route::get('introduce', 'IntroduceController@index')->name("get.introduce.index");
    Route::get('coaches', 'FormationController@coaches')->name("get.formation.coaches");
    Route::get('player', 'FormationController@player')->name("get.formation.player");
    Route::get('media', 'MediaController@index')->name("get.media.index");
    Route::get('schedule', 'MatchController@schedule')->name("get.match.schedule");
    Route::get('result', 'MatchController@result')->name("get.match.result");
    Route::get('rank', 'MatchController@rank')->name("get.match.rank");
});


Route::group([
    'middleware' => ["user"],
    "prefix" => "/",
], function () {
    Route::get('cart', 'SellController@cart')->name("get.sell.cart");
    Route::post('insert-cart', 'SellController@insertCart')->name("post.sell.insertCart");
    Route::post('update-cart', 'SellController@updateCart')->name("post.sell.updateCart");
    Route::get('order', 'SellController@order')->name("get.sell.order");
    Route::get('checkout', 'SellController@checkout')->name("get.sell.checkout");
    Route::post('checkout', 'SellController@payment')->name("post.sell.payment");
    Route::get('stripe/{total}', 'SellController@stripe')->name("get.sell.stripe");
    Route::post('stripe/{total}', 'SellController@stripePost')->name('stripe.post');
});