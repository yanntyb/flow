<?php

use App\Http\Controllers\DummyController;
use App\Http\Controllers\FileController;
use App\Models\File\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/dummy')->group(function(){
    Route::get('/test',[DummyController::class, 'test'])->name('test');
    Route::get('/insert', function(){
        try{
            $file = File::query()->first();
        }
        catch (Exception $e){
            ds($e)->die();
        }
    });
    Route::get('/link/{slug?}', [FileController::class, 'getFile'])->name('file.get');

});




