<?php

use App\Http\Controllers\HamaAnggurController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VarietasAnggurController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages.auth.login');
// });

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.main');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');


    Route::middleware(['check.admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('varietas', VarietasAnggurController::class);
        Route::resource('hama', HamaAnggurController::class);
    });
});
