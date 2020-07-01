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
    Route::middleware('auth:sanctum')->post('/logout', 'API\AuthController@logout')->name('auth.logout');
    Route::middleware('auth:sanctum')->get('/user', 'API\AuthController@user')->name('auth.user');
});

Route::prefix('/categories')->group(function () {
    Route::get('/', 'API\CategoryController@index')->name('category.all');
    Route::middleware('auth:sanctum')->post('/', 'API\CategoryController@store')->name('category.store');
    Route::middleware('auth:sanctum')->put('/', 'API\CategoryController@update')->name('category.update');
    Route::middleware('auth:sanctum')->delete('/{ids}', 'API\CategoryController@destroy')->name('category.delete');
});

Route::prefix('/articles')->group(function () {
    Route::get('/', 'API\ArticleController@index')->name('article.all');
    Route::get('/{article_id}/show', 'API\ArticleController@show')->name('article.show');
    Route::middleware('auth:sanctum')->post('/', 'API\ArticleController@store')->name('article.store');
    Route::middleware('auth:sanctum')->put('/', 'API\ArticleController@update')->name('article.update');
    Route::middleware('auth:sanctum')->delete('/{ids}', 'API\ArticleController@destroy')->name('article.delete');
});
