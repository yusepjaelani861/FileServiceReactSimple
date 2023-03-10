<?php

use App\Http\Controllers\API\FilesController;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\UploadController;
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


# POST Method
Route::post('/upload', [UploadController::class, 'upload']); // Upload File
Route::post('/rename', [FilesController::class, 'rename']); // Rename File
Route::post('/delete', [FilesController::class, 'delete']); //  Delete File


# GET Method
Route::get('/list', [FilesController::class, 'list']); //   List File
Route::get('/search', [FilesController::class, 'search']); //   Search File
Route::get('/filter', [FilesController::class, 'filter']); //   Filter File
Route::get('/image/{file_id}', [FilesController::class, 'getImage']); //  Get Image

# Create Token
Route::post('/create-token', [TokenController::class, 'create']); //   Create Token
