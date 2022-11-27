<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [WelcomeController::class, 'homepage'])->name('homepage');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
Route::get('/auth', [WelcomeController::class, 'auth'])->name('user-auth');

///owner
Route::get('/homeowner', [OrderController::class, 'homeOwner'])->name('homeOwner');
Route::get('/maintenance', [OrderController::class, 'maintenance'])->name('maintenance');
Route::post('/maintenance-submit', [OrderController::class, 'maintenanceCreate'])->name('maintenanceSubmit');
Route::get('/maintenance/sign/{hash}', [OrderController::class, 'maintenanceSign'])->name('maintenanceSign');
Route::post('/owner-request', [OrderController::class, 'create']);
Route::get('/checkout/{hash}', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/stripe-webhook', [OrderController::class, 'handleStripe']);
Route::get('/success/{hash}', [OrderController::class, 'checkoutSuccess'])->name('checkout_success');
Route::get('/cancel/{hash}', [OrderController::class, 'checkoutFail'])->name('checkout_fail');
Route::get('/order/{hash}', [OrderController::class, 'order'])->name('order');
Route::post('/process-to-checkout', [OrderController::class, 'processToCheckout'])->name('processToCheckout');
Route::post('/paypal-handler', [OrderController::class, 'handlePaypal'])->name('paypal-handler');

///contact
Route::post('/contact-request', [WelcomeController::class, 'send']);

///services
Route::get('/services', [WelcomeController::class, 'services'])->name('services');

//sign
Route::post('/sign-img',[WelcomeController::class,'signImg'])->name('signImg');

/////
Route::get('/sign', [WelcomeController::class, 'sign'])->name('sign');
Route::post('/viw-pdf', [WelcomeController::class, 'ForPdf'])->name('ForPdf');
Route::get('/request-quote', [WelcomeController::class, 'requestQuote'])->name('requestQuote');
Route::post('/request-quote-submit', [WelcomeController::class, 'requestQuoteSubmit'])->name('requestQuoteSubmit');

Route::post('/gallery-data', [DocumentController::class, 'galleryData'])->name('galleryData');
//TODO SESSION VALIDATION
Route::post('/upload-document', [DocumentController::class, 'upload'])->name('uploadDocument');
Route::post('/remove-image', [DocumentController::class, 'remove'])->name('removeImage');
/////

//Auth
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

///profile
Route::get('/orders-profile', [AuthController::class, 'ordersPprofile'])->name('ordersprofile')->middleware('auth');
Route::get('/personal-info', [AuthController::class, 'personaIinfo'])->name('personalinfo')->middleware('auth');
Route::get('/profile-password', [AuthController::class, 'profilePassword'])->name('profilepassword')->middleware('auth');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changepassword')->middleware('auth');
Route::post('/save-profile', [AuthController::class, 'saveProfile'])->name('saveProfile')->middleware('auth');
Route::get('order-data-profile',[AuthController::class, 'orderData'])->name('orderDataProfile');
Route::get('order-data-edit',[AuthController::class, 'orderGet'])->name('profileGetOrder');


Route::post('/users/sendPasswordRecover', [AuthController::class, 'sendPasswordRecover']);
Route::post('/checkRecoveryHash', [AuthController::class, 'checkRecoveryHash']);
Route::post('/recoveryPassword', [AuthController::class, 'recoveryPassword']);
