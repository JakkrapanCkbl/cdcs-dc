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

Route::get('/lineviewpdf/{id}', [CdcsController::class, 'lineview_pdf'])->name('lineviewpdf');

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
        Route::get('/mobileviewpdf/{id}', [CdcsController::class, 'lineview_pdf'])->name('mobileviewpdf');
    });
});

// ---------------------- others --------------------------------

Route::get('detect-device', function () {

    // object
    $agent = new \Jenssegers\Agent\Agent;

    // laptop/desktop
    $result1 = $agent->isDesktop();

    // mobile
    $result2 = $agent->isMobile();

    // tablet
    $result3 = $agent->isTablet();

    // returns boolean value of each variable
    echo $result1." , ".$result2. " , ".$result3; 
});

// Route::get('/downloadx', function () {
//     return '<a href="https://dccrstorage.file.core.windows.net/docs/Letters/04-2022/DC02-04-IE-PM02-00033/DC02-04-IE-PM02-000332552233879.pdf?sv=2020-08-04&ss=f&srt=sco&sp=rwdlc&se=2027-12-31T11:19:49Z&st=2022-03-16T03:19:49Z&spr=https&sig=BH4be9fKMnR%2BmnTd%2FPwdnJbOMleYYpAS%2BywaTpank60%3D">link text</a>';
// });
// Route::get('/test', [CdcsController::class, 'getdrive']);
//  Route::get('test', function() {
//         dd(Storage::disk('azure-file-storage'));
//         // dd(Storage::disk('azure-file-storage')->listAll());
//         // dd(Storage::disk('azure-file-storage')->exists('file.txt'));
//     });