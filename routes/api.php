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

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'API\AuthController@logout')->name('auth.logout');
        Route::get('/user', 'API\AuthController@user')->name('auth.user');
    });
});

Route::prefix('/categories')->group(function () {
    Route::get('/', 'API\CategoryController@index')->name('category.all');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'API\CategoryController@store')->name('category.store');
        Route::put('/', 'API\CategoryController@update')->name('category.update');
        Route::delete('/{ids}', 'API\CategoryController@destroy')->name('category.delete');
    });
});

Route::prefix('/articles')->name('article.')->group(function () {
    Route::get('/', 'API\ArticleController@index')->name('all');
    Route::get('/{article_slug}/show', 'API\ArticleController@show')->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/{id}/saveComment', 'API\ArticleController@saveComment')->name('saveComment');

        Route::put('/{id}/editComment', 'API\ArticleController@updateComment')->name('editComment');

        Route::delete('/{id}/deleteComment', 'API\ArticleController@deleteComment')->name('deleteComment');

        Route::post('/', 'API\ArticleController@store')->name('store');
        Route::put('/', 'API\ArticleController@update')->name('update');
        Route::delete('/{ids}', 'API\ArticleController@destroy')->name('delete');
    });
});
