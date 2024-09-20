<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VarietasAnggurController;
use App\Http\Controllers\PenyakitAnggurController;
use App\Http\Controllers\SebaranPenyakitController;
use App\Http\Controllers\SebaranVarietasController;
use App\Http\Controllers\CategoryClassController;
use App\Http\Controllers\ClassVideoController;
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
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');


    Route::middleware(['check.admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('varietas', VarietasAnggurController::class);
        Route::resource('penyakit', PenyakitAnggurController::class);
        Route::resource('sebaran_penyakit', SebaranPenyakitController::class);
        Route::resource('sebaran_varietas', SebaranVarietasController::class);
        Route::resource('category_class', CategoryClassController::class);
        Route::resource('course_video', ClassVideoController::class);
        // Route::put('/course_video/{id}', [CourseVideoController::class, 'update'])->name('course_video.update');
    });
});
