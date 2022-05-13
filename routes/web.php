<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CdcsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\it\ItController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/viewpdf/{id}', [CdcsController::class, 'view_pdf'])->name('viewpdf');
Route::get('/test', [CdcsController::class, 'getdrive']);
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