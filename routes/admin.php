<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\RequestsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MetaController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\SuperAdmin;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[AuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/login', [AuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('/logout', [AuthController::class, 'logout'])->name('adminLogout');


Route::group(['middleware' => ['adminauth', 'superAdmin']], function () {
    
    // Route::withoutMiddleware([SuperAdmin::class])->group(function () {
    Route::get('products',[ProductController::class, 'index'])->name('products');
    Route::get('products-data',[ProductController::class, 'data'])->name('productData');
    Route::get('products-get',[ProductController::class, 'get'])->name('productGet');
    Route::post('products-sort',[ProductController::class, 'sort'])->name('productsSort');
    Route::post('product-save',[ProductController::class, 'save'])->name('productSave');
    Route::post('product-remove',[ProductController::class, 'remove'])->name('productRemove');

    Route::get('orders',[OrderController::class, 'index'])->name('adminOrder');
    Route::get('order-data',[OrderController::class, 'data'])->name('orderData');
    Route::get('order',[OrderController::class, 'getOrder'])->name('aGetOrder');
    Route::post('order-save',[OrderController::class, 'saveOrder'])->name('saveOrder');
    // Route::post('save-review',[OrderController::class, 'saveReview'])->name('adminSaveReview');
    // Route::post('save-notes',[OrderController::class, 'saveNotes'])->name('adminSaveNotes');
    
    Route::get('profile',[AdminController::class, 'profile'])->name('adminProfile');
    Route::post('save-profile',[AuthController::class, 'saveProfile'])->name('adminSaveProfile');
    Route::post('change-password',[AuthController::class, 'changePassword'])->name('adminChangePassword');

    Route::post('upload-image',[ImageController::class, 'upload'])->name('aUpload');
    Route::post('change-image-color',[ImageController::class, 'changeImageColor'])->name('changeImageColor');
    Route::post('gallery-data',[ImageController::class, 'galleryData']);
    Route::post('gallery-sort',[ImageController::class, 'gallerySort']);
    Route::post('remove-image',[ImageController::class, 'remove'])->name('aRemoveImage');
    // });

	// Admin Dashboard
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('save-settings',[AdminController::class, 'saveSettings'])->name('saveAdminSettings');
    Route::post('save-contact',[AdminController::class, 'saveContact'])->name('saveAdminContact');

    //settings
    Route::get('settings',[SettingsController::class, 'settings'])->name('adminSettings');
    Route::post('settings',[SettingsController::class,'updateSettings'])->name('updateSettings');
    Route::post('update-settings-price',[SettingsController::class,'updateSettingsPrice'])->name('updateSettingsPrice');
    Route::post('update-img',[SettingsController::class,'updateimg'])->name('updateimg');
    //slider
    Route::get('slider',[SliderController::class, 'slider'])->name('adminSlider');
    Route::get('slider-data',[SliderController::class, 'sliderData'])->name('aSliderData');
    Route::get('slider-get',[SliderController::class, 'getSlider'])->name('aGetSlider');
    Route::post('slider-save',[SliderController::class, 'saveSlider'])->name('adminSliderSave');
    Route::post('slider-remove',[SliderController::class, 'removeSlider'])->name('aRemoveSlider');
    Route::post('slider-ordering',[SliderController::class, 'reorderingSlider'])->name('aSliderSort');

    //meta
    Route::get('meta',[MetaController::class, 'meta'])->name('adminMeta');
    Route::get('meta-data',[MetaController::class, 'metaData'])->name('aMetaData');
    Route::get('meta-get',[MetaController::class, 'getMeta'])->name('aGetMeta');
    Route::post('meta-save',[MetaController::class, 'saveMeta'])->name('adminMetaSave');

    //Categories
    Route::get('collections',[CollectionController::class, 'collections'])->name('adminCollections');
    Route::get('collections-data',[CollectionController::class, 'collectionsData'])->name('aCollectionsData');
    Route::get('collection-get',[CollectionController::class, 'getcollection'])->name('aGetCollection');
    Route::post('collection-save',[CollectionController::class, 'saveCollection'])->name('adminCollectionSave');
    Route::post('collection-remove',[CollectionController::class, 'removeCollection'])->name('aRemoveCollection');
    Route::post('collection-ordering',[CollectionController::class, 'reorderingCollection'])->name('aCollectionsSort');
    Route::post('collection-unAttachImage',[CollectionController::class, 'unAttachImage'])->name('aCollectionsUnAttachImage');

    //Dictionary
    Route::get('dictionary',[DictionaryController::class, 'index'])->name('adminDictionary');
    Route::get('dictionary-data',[DictionaryController::class, 'data'])->name('aDictionaryData');
    Route::get('dictionary-get',[DictionaryController::class, 'get'])->name('aGetDictionary');
    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('adminDictionarySave');

    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('adminDicionarySave');
    Route::post('dictionary-sync',[DictionaryController::class, 'sync'])->name('aSyncDictionary');


    // Route::get('user-data',[UserController::class, 'userData'])->name('aUserData');
    // Route::post('user-vierfy',[UserController::class, 'verify'])->name('aUserSaveVerify');
    // Route::post('user-upload-avatar',[ImageController::class, 'upload'])->name('uploadAvatar');

    //clear all cache
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });
});
