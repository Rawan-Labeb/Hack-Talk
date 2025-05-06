<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\SocialAuthController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=> 'v1'], function(){

    Route::group(['controller' => AuthController::class], function(){
        Route::post('register','register');
        Route::post('login','login');
        Route::post('logout','logout')->middleware('auth:sanctum');
    });

    Route::group(['controller' => ProfileController::class, 'middleware' => 'auth:sanctum'], function(){
        Route::post('profile', 'profile');
        Route::post('change-password', 'changePassword');
    });

    Route::group(['controller' => ResetPasswordController::class], function(){
        Route::post('reset-password', 'resetPassword');
        Route::post('verify-code', 'verifyCode');
        Route::post('new-password', 'newPassword');
    });

    Route::group(['controller' => SocialAuthController::class], function(){
        Route::get('auth/{provider}/redirect', 'redirectToProvider');
        Route::get('auth/{provider}/callback', 'handleProviderCallback');
    });

    Route::group(['controller' => MediaController::class], function(){
        Route::post('media', 'store')->middleware('auth:sanctum');
    });

    Route::group(['controller' => ContactUsController::class], function(){
        Route::post('send-message', 'sendMessage')->middleware('auth:sanctum');
    });

    Route::post('rating', [RatingController::class,'store'])->middleware('auth:sanctum');
        // http://127.0.0.1:8000/api/v1/auth/google/callback

});
