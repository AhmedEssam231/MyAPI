<?php

use App\Http\Controllers\API\authController;

use App\Http\Controllers\API\productController;

use Illuminate\Support\Facades\Route;

   
Route::controller(authController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::delete('delete/{id}','delete');
});


Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
});