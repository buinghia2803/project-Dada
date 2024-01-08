<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for admin.
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Go to link /api/admin/test
Route::get('test', function () {
    echo ('Testing admin api');
});

/*
|--------------------------------------------------------------------------
| API Routes for not Auth.
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});

/*
|--------------------------------------------------------------------------
| API Routes for Auth.
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['auth:api'], 'namespace' => 'Auth'], function () {
    Route::post('/logout', 'AuthController@logout');
    Route::post('/change-pass', 'AuthController@changePassWord');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'AuthController@userProfile');
});

/*
|--------------------------------------------------------------------------
| API Routes for Forgot-password.
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Api\V1\Admin'], function () {
    /*
    |--------------------------------------------------------------------------------
    | API Password reset.
    |--------------------------------------------------------------------------------
    */
    Route::post('generate-link', 'AdminController@getGenerateLinkResetPW');
    Route::post('check-token', 'AdminController@checkToken');
    Route::post('password-reset', 'AdminController@passwordReset');
});

/*
|--------------------------------------------------------------------------
| API Routes for Setting.
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    /*
    |--------------------------------------------------------------------------------
    | API Setting.
    |--------------------------------------------------------------------------------
    */
    Route::post('setting', 'SettingController@updateOrCreate');
    Route::get('setting', 'SettingController@index');
});


/*
|--------------------------------------------------------------------------
| API Routes for Feature.
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Api\V1'], function () {
    /*
  |--------------------------------------------------------------------------
  | API Routes for upload file CKEditor.
  |--------------------------------------------------------------------------
  |
  */
    Route::post('upload-file', 'UploadFileController@uploadFile');
});

Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api\V1\Admin'], function () {
    /*
  |--------------------------------------------------------------------------
  | API Routes for admin.
  |--------------------------------------------------------------------------
  |
  */
    Route::post('upload', 'UserController@uploadFileLocal')->name('user.uploadFileLocal');
    Route::post('upload-s3', 'UserController@uploadFileS3')->name('user.uploadFileS3');

    /*
  |--------------------------------------------------------------------------
  | API Routes for admin.
  |--------------------------------------------------------------------------
  |
  */
    Route::apiResource('role', 'RoleController');
    Route::apiResource('user', 'UserController');
    Route::apiResource('permission', 'PermissionController');
});



Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api\V1'], function () {
    /*
  |--------------------------------------------------------------------------
  | API Routes for admin.
  |--------------------------------------------------------------------------
  |
  */
    Route::get('mail-template/get-mail-template-by-type', 'MailTemplateController@getMailTemplateByType');
    Route::apiResource('mail-template', 'MailTemplateController', [
        'parameters' => [
            'mail-template' => 'mailTemplate',
        ],
    ]);
});


Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api\V1\Admin'], function () {
    // Router  user
    Route::apiResource('account-user', 'UserController', [
        'parameters' => [
            'account-user' => 'user',
        ],
    ]);
    // End router  user

    // Router  contract-offer
    Route::apiResource('offer', 'ContractOfferController', [
        'parameters' => [
            'offer' => 'contractOffer',
        ],
    ]);
    // End router  nft
    // Router  contract-nft
    Route::apiResource('nft', 'ContractNftController', [
        'parameters' => [
            'nft' => 'contractNft',
        ],
    ]);
    // End router  contract-nft

    // Router  contract-payment
    Route::post('payment/{id}', 'ContractPaymentController@update');
    Route::apiResource('payment', 'ContractPaymentController', [
        'parameters' => [
            'payment' => 'contractPayment',
        ],
    ]);
    // End router  contract-payment

    // Router  notification
    Route::apiResource('notification', 'NotificationController', [
        'parameters' => [
            'notification' => 'notification',
        ],
    ]);
    // End router  notification

    // Router  revenue
    Route::get('revenue/by-list-user', 'RevenueController@sumDataByUser');
    Route::get('revenue', 'RevenueController@index');
    // End router  revenue
});
