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

//Auth
Route::post('/sign-up', 'API\AuthController@signUp');
Route::post('/sign-up-verify', 'API\AuthController@signUpVerify');
Route::post('/sign-in', 'API\AuthController@signIn');
Route::post('/sign-in-verify', 'API\AuthController@signInVerify');

Route::get('/dictionary', 'API\UserController@dictionary');

Route::group(['middleware' => ['auth:sanctum']], function () {

    //User managment
    Route::post('/user/fullname', 'API\UserController@updateFullname');
    Route::post('/user/address', 'API\UserController@updateAddress');
    Route::post('/user/about', 'API\UserController@updateAbout');
    Route::post('/user/language', 'API\UserController@updateLanguage');
    Route::post('/user/avatar', 'API\UserController@updateAvatar');
    Route::post('/user/remove-avatar', 'API\UserController@removeAvatar');
    Route::post('/user/change-type', 'API\UserController@changeType');
    Route::post('/user/change-phone', 'API\UserController@changePhone');
    Route::post('/user/change-phone-verify', 'API\UserController@changePhoneVerify');
    Route::get('/logout', 'API\AuthController@logout');
    Route::get('/remove', 'API\UserController@remove');
    
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        if($user->avatar && $user->avatar != null){
            $user->avatar = asset('images/avatar/'.$user->avatar);
        }
        return response()->json(['success' => array('user'=>$request->user())]);
    });

    //User mange service
    Route::post('/user/save-service', 'API\UserController@saveService');
    Route::get('/user/service', 'API\UserController@getService');
    Route::get('/user/services', 'API\UserController@getServices');
    Route::post('/user/remove-service', 'API\UserController@remvoeService');
    Route::post('/user/remove-image', 'API\UserController@remvoeImage');
    Route::post('/user/expoToken', 'API\UserController@saveToken');

    //Order managment
    Route::get('/employers', 'API\UserController@employers');
    Route::get('/employee', 'API\UserController@employee');
    Route::post('/order/send-request', 'API\OrderController@sendRequest');
    Route::post('/order/cancel', 'API\OrderController@cancelRequest');
    Route::get('/customer/orders', 'API\OrderController@getCustomerOrders');
    Route::post('/customer/feedback', 'API\OrderController@feedback');
    Route::post('/customer/bookmark', 'API\OrderController@bookmark');
    Route::post('/customer/remove-bookmark', 'API\OrderController@removeBookmark');
    Route::get('/employee/orders', 'API\OrderController@getEmployeeOrders');
    Route::post('/employee/approve', 'API\OrderController@approve');
    Route::post('/employee/decline', 'API\OrderController@decline');
    Route::get('/customer/bookmarks', 'API\OrderController@bookmarks');
    Route::post('/notification', 'API\OrderController@notification');

    Route::get('/employee/verify', 'API\UserController@employeeVerify');
    Route::post('/employee/verify-add-image', 'API\UserController@employeeVerifyAddImage');
    Route::post('/employee/verify-remove-image', 'API\UserController@employeeVerifyRemoveImage');
    Route::post('/employee/verify-submit', 'API\UserController@employeeVerifySubmit');
});

Route::get('/wrong-token', function () {
    return response()->json(['errors' => array('code'=>"Wrong or expierd token")], 401);
})->name('wrong-token');

// Route::get('/404', function () {
//     return response()->json(['errors' => "undefined_method"], 404);
// })->name('404');