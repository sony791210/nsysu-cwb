<?php


Route::namespace('Api')->group(function () {
//    Route::prefix('auth')->group(function () {
//        Route::post('/token', 'AuthController@generateToken')->middleware('api.v1.generateToken');
//    });
    Route::prefix('email')->group(function () {
            Route::post('/sendquestion', 'SendEmailControllers@question');
    });
});

Route::namespace('Api\V1')->prefix('v1')->group(function () {
    Route::prefix('test')->group(function () {
        Route::post('/', 'SendEmailControllers@test');
});
});
