<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

//Authenticate
Route::get('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/registr', [AuthController::class, 'registr']);


Route::get('/', [MainController::class, 'index']);

Route::get('/gallery/{img}', function($img) {
    return view('main.gallery', ['img' => $img]);
});


Route::get('/about', function(){
    return view('main.about');
});
Route::get('/contacts', function(){
    $data = [
        'city'=>'Moscow',
        'street'=>'Semenovskaya',
        'house'=>38,
    ];
    return view('main.contact', ['data'=>$data]);
});