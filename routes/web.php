<?php

use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\Web\AppAccessController;
use App\Http\Controllers\Web\FilesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/files', [FilesController::class, 'list'])->name('files.list');
    Route::get('/upload', [FilesController::class, 'upload'])->name('files.upload');
    Route::get('/applist', [AppAccessController::class, 'list'])->name('app.list');
    Route::get('/api', function () {
        return Inertia::render('API');
    });
    Route::get('/create-app', function () {
        return Inertia::render('CreateAppAccess');
    });

    # Post Method
    Route::post('/delete', [FilesController::class, 'delete'])->name('files.delete');
    Route::post('/upload', [FilesController::class, 'store'])->name('files.store');
    Route::post('/app-access/create', [TokenController::class, 'webcreate'])->name('app-access.create');
});

Route::get('/download/{id}', [FilesController::class, 'download'])->name('files.download');

Route::get('/test', function () {
   return view('test');
});

require __DIR__ . '/auth.php';
