<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiMailController;
use App\Http\Controllers\Api\ApiProducerController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiSlideController;
use App\Http\Controllers\Api\ApiTypeController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/loginGoogle', [ApiAuthController::class, 'loginGoogle']);
Route::get('/types', [ApiTypeController::class, 'getAllType']);
Route::get('/producers', [ApiProducerController::class, 'getAllProducer']);
Route::get('/producers/types/{id}', [ApiProducerController::class, 'getProducersByTypeId']);
Route::get('/products', [ApiProductController::class, 'getProductBySearch']);
Route::get('/products/detail/{id}', [ApiProductController::class, 'getProductById']);
Route::get('/products/relative/{id}', [ApiProductController::class, 'getRelativeProducts']);
Route::get('/slides/{id}', [ApiSlideController::class, 'getSlideByProductId']);

Route::get('/send_email', [ApiMailController::class, 'sendMail']);

Route::middleware('auth:api')->group(function() {
    Route::get('/check_token', [ApiAuthController::class, 'checkToken']);
    Route::get('/logout', [ApiAuthController::class, 'logout']);
    Route::post('/products/store', [ApiProductController::class, 'store']);
    Route::post('/products/update/{id}', [ApiProductController::class, 'update']);
    Route::delete('/products/delete/{id}', [ApiProductController::class, 'delete']);
    Route::post('/slides/store', [ApiSlideController::class, 'store']);
    Route::put('/slides/update/{id}', [ApiSlideController::class, 'update']);
    Route::delete('/slides/delete/{id}', [ApiSlideController::class, 'delete']);
});
