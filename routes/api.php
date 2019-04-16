<?php

use Illuminate\Http\Request;

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



Route::group(['middleware' => ['json.response']], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // public routes
    Route::post('/login', 'Api\AuthController@login')->name('login.api');
    Route::post('/register', 'Api\AuthController@register')->name('register.api');

    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
        Route::post('/profile', 'ProfileController@store')->name('register_profile.api');
        Route::get('/profile', 'ProfileController@index')->name('list_profile.api');
    });


    Route::get('/storage/{filename}', function ($filename)
    {
        $path = storage_path('app/profile/' . $filename);
        if (!File::exists($path)) {
            $backup_image = public_path("/images/thumb.png");

            $file = File::get($backup_image);
            $type = File::mimeType($backup_image);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
            
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

});

