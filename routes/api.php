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

Route::prefix('/auth')->group(function () {
    Route::post('/register', 'API\AuthController@register')->name('auth.register');
    Route::post('/login', 'API\AuthController@login')->name('auth.login');
    Route::post('/logout', 'API\AuthController@logout')->name('auth.logout');
    Route::get('/user', 'API\AuthController@user')->name('auth.user');
});
