<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIControllers\ArticleController;
use App\Http\Controllers\APIControllers\AuthController;
use App\Http\Controllers\APIControllers\CommentController;

//Authenticate
Route::get('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/registr', [AuthController::class, 'registr']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Article
Route::resource('/articles', ArticleController::class)->middleware('auth:sanctum');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show')->middleware('saveclick');

//Comments
Route::controller(CommentController::class)->prefix('/comment')->middleware('auth:sanctum')->group(function () {
    Route::post('', 'store');
    Route::get('/{id}/edit', 'edit');
    Route::post('/{comment}/update', 'update');
    Route::get('/{comment}/delete', 'destroy');
    Route::get('/index', 'index')->name('comment.index');
    Route::get('/{comment}/accept', 'accept');
    Route::get('/{comment}/reject', 'reject');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
