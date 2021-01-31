<?php


use Illuminate\Support\Facades\Route;

Route::post('auth/login', 'AuthController@login');

Route::post('auth/logout', 'AuthController@logout');

Route::post('auth/refresh-token', 'AuthController@refresh');

Route::post('auth/request/password/reset', 'AuthController@sendAdminResetMail');

Route::post('auth/password/reset', 'AuthController@resetPassword');

Route::get('/', 'AuthController@getAuthUser');

Route::post('add-new-admin', 'NewAdminsController@newAdmin');

Route::post('change-password', 'NewAdminsController@changePassword');

Route::post('{admin}/block', 'NewAdminsController@blockAdmin');

Route::post('{admin}/unblock', 'NewAdminsController@unBlockAdmin');

Route::patch('update/', 'AdminsController@updateAdmin');

Route::get('fetch-users', 'AdminsController@getUsers');

Route::get('fetch-admins', 'AdminsController@fetchAdmins');

Route::get('fetch-shops', 'AdminsController@getShops');

Route::post('block/{user}/user', 'AdminsController@blockUser');

Route::post('unblock/{user}/user', 'AdminsController@unblockUser');

Route::post('block/{shop}/merchandiser', 'AdminsController@blockShop');

Route::post('unblock/{shop}/merchandiser', 'AdminsController@unBlockShop');

Route::get('get-shop/{shop}/details', 'AdminsController@shopDetails')->name('shop.details');

Route::delete('shop/{shop}/delete', 'AdminsController@deleteShop');

Route::delete('product/{product}/delete', 'AdminsController@deleteProduct');

Route::delete('product-review/{review}/delete', 'AdminsController@deleteProductReview');

Route::delete('shop-review/{review}/delete', 'AdminsController@deleteShopReview');

Route::get('get-shop/{shop}/reviews', 'AdminsController@getShopReviews');

Route::get('get-product/{product}/reviews', 'AdminsController@getProductReviews');

Route::delete('user/{user}/delete-account', 'AdminsController@deleteUser');


Route::get('shop-reports', 'AdminsController@getShopReport');

Route::get('product-reports', 'AdminsController@getProductReport');

Route::get('campus/{campus}/carousel-images', 'CarouselController@getCourosleIamges');

Route::post('campus/{campus}/carousel-images', 'CarouselController@addCarouselImage');

Route::delete('campus-carousel/{carouselImage}/delete', 'CarouselController@deleteCarouselImage');