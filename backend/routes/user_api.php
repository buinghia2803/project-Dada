<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for User.
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Go to link /api/user/test
Route::get('test', function () {
    echo ('Testing user api');
});

/*
|--------------------------------------------------------------------------
| API Routes for not Auth.
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Auth'], function () {
});

/*
|--------------------------------------------------------------------------
| API Routes for Setting User.
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Api\V1\User'], function () {
    Route::post('/login_user', 'AuthController@loginUser');
    Route::post('/logout', 'AuthController@logout');
    Route::get('/me', 'AuthController@userProfile');

    Route::get('/dad', 'AuthController@dadInformation');

    // Router  notification-user
    Route::apiResource('notification-user', 'NotificationUserController', [
        'parameters' => [
            'notification-user' => 'notificationUser',
        ],
    ]);
    Route::post('notification-update-status', 'NotificationUserController@updateStatusNotificationUser');
    // End router  notification-user

    /*
    |--------------------------------------------------------------------------------
    | API Setting User.
    |--------------------------------------------------------------------------------
    */
    Route::get('setting', 'SettingUserController@getNotification');
    Route::get('setting/user_id', 'SettingUserController@getByUserId');

    Route::post('setting', 'SettingUserController@updateOrCreate');
    Route::get('setting/{id}', 'SettingUserController@show');

    /*
    |--------------------------------------------------------------------------------
    | API Contract Offer.
    |--------------------------------------------------------------------------------
    */
    //list contract offer
    //    Route::get('contract-offer/user/{id}', 'ContractOfferController@index');
    Route::get('contract-offer/user/{id}', 'ContractOfferController@listByUser');
    /*
    |--------------------------------------------------------------------------------
    | API Contract Nft User.
    |--------------------------------------------------------------------------------
    */
    Route::apiResource('contract-nft', 'ContractNftController', [
        'parameters' => [
            'contract-nft' => 'contractNft',
        ],
    ]);

    Route::post('contract-nft-update', 'ContractNftController@createContractNft');

    //create update detail contract offer
    Route::apiResource('contract-offer', 'ContractOfferController', [
        'parameters' => [
            'contract-offer' => 'contractOffer',
        ],
    ])->except([
        'index', 'destroy',
    ]);
    // Get Contract Offer
    Route::post('offer', 'ContractOfferController@getContractOfferByToken');
    // Router  user
    Route::get('profile/{id}', 'UserController@profile');

    Route::post('/update-profile', 'UserController@updateProfile');

    Route::put('/update_type/{id}', 'AuthController@updateType');

    // End router  user

    //send mail to artist
    Route::post('send-mail-to-artist', 'ContractOfferController@sendMailToArtist');
    Route::post('check-offer-email', 'ContractOfferController@checkOfferEmail');

    // Router  token
    Route::apiResource('token', 'TokenController', [
        'parameters' => [
            'token' => 'token',
        ],
    ]);
    // End router  token
});
