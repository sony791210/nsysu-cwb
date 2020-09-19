<?php


Route::namespace('API')->group(function () {
//    Route::prefix('auth')->group(function () {
//        Route::post('/token', 'AuthController@generateToken')->middleware('api.v1.generateToken');
//    });
    // Route::prefix('email')->group(function () {
    //         Route::post('/sendquestion', 'SendEmailControllers@question');
    // });

    Route::prefix('cwbData')->group(function () {
        Route::get('/getListInfo/{name}', 'CWBDataController@getListInfo');
        Route::get('/getDetailData/{name}', 'CWBDataController@getDetailData');
        Route::get('/getSurfaceData', 'CWBDataController@getSurfaceData');
    });

    
});






// Route::namespace('API\V1')->prefix('v1')->group(function () {
//     Route::prefix('test')->group(function () {
//         Route::post('/', 'SendEmailControllers@test');
// });
// });
