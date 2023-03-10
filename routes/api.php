<?php

use App\Http\Controllers\FileController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/file')->group(function(){
    Route::match(['get','post'],'/upload', [FileController::class, 'upload'])->name('file.upload');
    Route::match(['get','post'],'/link/{slug?}', [FileController::class, 'getFile'])->name('file.get');
    Route::get('/show/{slug?}', [FileController::class, 'show'])->name('file.show');

});

