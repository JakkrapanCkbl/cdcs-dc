<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\It\ItController;
use App\Http\Controllers\Cdcs\CdcsController;

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

Auth::routes();


// Route::get('/test', [CdcsController::class, 'getdrive']);
//  Route::get('test', function() {
//         dd(Storage::disk('azure-file-storage'));
//         // dd(Storage::disk('azure-file-storage')->listAll());
//         // dd(Storage::disk('azure-file-storage')->exists('file.txt'));
//     });

Route::prefix('it')->name('it.')->group(function(){
    Route::middleware(['guest:it','PreventBackHistory'])->group(function(){
        Route::view('/login','it.login')->name('login');
        Route::post('/check',[ItController::class,'check'])->name('check');
    });

    Route::middleware(['auth:it','PreventBackHistory'])->group(function(){
        Route::view('/home','it.home')->name('home');
        Route::post('logout',[ItController::class,'logout'])->name('logout');
    });
});

Route::prefix('cdcs')->name('cdcs.')->group(function(){
    Route::middleware(['guest:cdcs','PreventBackHistory'])->group(function(){
        Route::view('/login','cdcs.login')->name('login');
        Route::post('/check',[CdcsController::class,'check'])->name('check');
    });

    Route::middleware(['auth:cdcs','PreventBackHistory'])->group(function(){
        // Route::view('/home','cdcs.home')->name('home');
        Route::get('/home', [CdcsController::class, 'index'])->name('home');
        Route::post('logout',[CdcsController::class,'logout'])->name('logout');
        Route::get('/search', [CdcsController::class, 'search'])->name('search');
        Route::get('/viewpdf/{id}', [CdcsController::class, 'view_pdf'])->name('viewpdf');
        Route::get('/downloadpdf/{id}', [CdcsController::class, 'download_pdf'])->name('downloadpdf');
    });
});