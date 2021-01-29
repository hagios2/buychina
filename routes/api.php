<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AuthController@login');

    Route::post('logout', 'AuthController@logout');

    Route::post('refresh-token', 'AuthController@refresh');

    Route::get('user', 'AuthController@getAuthUser');

    Route::patch('update/{user}/user', 'UsersRegisterController@update');

    Route::delete('user/delete', 'UsersRegisterController@destroy');

    Route::post('email/verify', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name

    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

    Route::post('request/password/reset', 'PasswordResetController@sendResetMail');

    Route::post('reset/password/', 'PasswordResetController@reset');

    Route::post('change/password', 'PasswordResetController@changeUserPassword');

    Route::post('upload/valid-id', 'AuthController@saveValidId');

});

Route::post('register-user', 'UsersRegisterController@register');

Route::post('register-merchandiser', 'MerchandiserRegisterController@register');

Route::get('campuses', 'ResourceController@getCampus');

Route::get('get/campus/{campus}/carousel', 'ResourceController@getCourosleIamges');

Route::get('categories', 'ProductsController@getCategories');

Route::get('category/{category}/products', 'ProductsController@getCategorysProduct');

Route::get('product/{product}/details', 'ProductsController@getProductDetails')->name('product.details');

Route::get('/{category}/product-index', 'ProductsController@index');

Route::post('user/{user}/add-cart', 'ProductsController@saveCart');

Route::get('user-cart', 'ProductsController@getCart');

Route::get('shop-types', 'ResourceController@getShopTypes');

Route::get('merchandiser/{shops}/products','ProductsController@fetchShopsProduct');

Route::get('all-shops','ProductsController@fetchShops');

Route::get('get-campus/{campus}/shop','ProductsController@campusShop');

Route::get('get-campus/{campus}/product','ProductsController@campusProduct');

Route::post('follow/{shop}/shop','FollowersController@followShop');

Route::post('unfollow/{shop}/shop','FollowersController@unFollowShop');

Route::get('following-shops','FollowersController@fetchfollowingShops');

Route::post('make-enquiries','EnquiryFormController@handler');

Route::get('shop/{shop}/details', 'ProductsController@merchandiserDetails');

Route::get('shop/{merchandiser}/reviews', 'ReviewsController@fetchShopReviews');

Route::post('add-shop/reviews', 'ReviewsController@storeShopReview');

Route::get('product/{product}/reviews', 'ReviewsController@fetchProductReviews');

Route::post('add-product/reviews', 'ReviewsController@storeProductReview');

//Route::post('add-product/reviews', 'ReviewsController@storeProductReview');

Route::post('add-product/report', 'ReportsController@saveProductReport');

Route::post('add-shop/report', 'ReportsController@saveShopReport');

Route::get('fetch/new-this-week', 'ResourceController@newThisWeek');

Route::get('get/campus/{campus}/new-this-week', 'ResourceController@campusnewThisWeek');

Route::group(['prefix' => 'merchandiser'], function () {

    Route::post('login', 'MerchandiserAuthController@login');

    Route::get('/', 'MerchandiserAuthController@getAuthUser');

    Route::post('activate/free/trial', 'MerchandiserAuthController@toggleToFreeTrial');

    Route::post('logout', 'MerchandiserAuthController@logout');

    Route::post('refresh-token', 'MerchandiserAuthController@refresh');

    Route::patch('/{merchandiser}/update', 'MerchandiserRegisterController@update');

    Route::post('/{merchandiser}/store-photos', 'MerchandiserRegisterController@saveAvatarAndCover');

    Route::delete('/delete', 'MerchandiserRegisterController@destroy');

    Route::post('email/verify', 'VerificationController@verifyShop')->name('merchandiser.verification.verify'); // Make sure to keep this as your route name

    Route::post('email/resend', 'VerificationController@resend')->name('merchandiser.verification.resend');

    Route::post('request/password/reset', 'PasswordResetController@sendShopResetMail');

    Route::post('reset/password/', 'PasswordResetController@shopReset');

    Route::post('change/password', 'PasswordResetController@changeShopPassword');
});



Route::group(['prefix' => 'e-trader'], function () {

    Route::post('/create-category', 'SellersController@createCategory');

   // Route::get('/categories', 'SellersControllerController@getCategories');

    Route::post('/{category}/add-product', 'SellersController@storeProduct');

    Route::post('/{product}/product-images', 'SellersController@saveProductImages');

    Route::post('/product/{product}/update', 'SellersController@updateProduct');

    Route::delete('/product/{product}/delete', 'SellersController@deleteProduct');

    Route::get('get-user-products', 'SellersController@getUserProduct');
});

Route::post('user/toggle/{product}/to-free-trial', 'SellersController@toggleProductToFreeTrial');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::post('auth/login', 'AuthController@login');

    Route::post('auth/logout', 'AuthController@logout');

    Route::post('auth/refresh-token', 'AuthController@refresh');

    Route::get('/', 'AuthController@getAuthUser');

    Route::post('create/campus', 'AdminsController@createCampus');

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

});

Route::get('search/item', 'SearchController@search');


#------------------------ Payment Integration --------------------------------------

Route::post('/user/product/payment', 'UserSellerPaymentController@payment')->name('user.seller.pay');

Route::post('/user/product/payment/callback', 'UserSellerPaymentController@callback')->name('user.seller.callback');

Route::post('/shop/payment', 'PaymentController@payment')->name('merchandiser.pay');

Route::get('shop/payment/transactions', 'PaymentController@paymentTransactions');

Route::get('user/product/payment/transactions', 'UserSellerPaymentController@paymentTransactions');

Route::post('/shop/payment/callback', 'PaymentController@callback')->name('shop.payment.callback');

#------------------------ End of Payment Integration --------------------------------------

Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});
