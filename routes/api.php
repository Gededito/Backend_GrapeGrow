<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PenyakitAnggurController;
use App\Http\Controllers\Api\VarietasAnggurController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SebaranPenyakitController;
use App\Http\Controllers\Api\SebaranVarietasController;
use App\Http\Controllers\Api\ModulBudidayaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Register
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::post('/login', [AuthController::class, 'login']);

// Group Middleware
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // API Get All Hama
    Route::get('/penyakit', [PenyakitAnggurController::class, 'index']);

    // API Get By Id Hama
    Route::get('/penyakit/{id}', [PenyakitAnggurController::class, 'getById']);

    // API Get All Varietas
    Route::get('/varietas', [VarietasAnggurController::class, 'index']);

    // API Get By Id Varietas
    Route::get('/varietas/{id}', [VarietasAnggurController::class, 'getById']);

    // API Get Posts
    Route::get('/posts', [PostController::class, 'index']);

    // API Add PostForum
    Route::post('/post/store', [PostController::class, 'store']);

    // API Add LikeForum
    Route::post('/post/like/{post_id}', [PostController::class, 'likePost']);

    // API Add CommentForum By Id PostForum
    Route::post('/post/comment/{post_id}', [PostController::class, 'comment']);

    // API Get CommentForum By Id PostForum
    Route::get('/post/comments/{post_id}', [PostController::class, 'getComments']);

    // API Add SebaranPenyakit
    Route::post('/sebaran_penyakit/add', [SebaranPenyakitController::class, 'store']);

    // API Update SebaranPenyakit
    Route::put('/sebaran_penyakit/{id}', [SebaranPenyakitController::class, 'update']);

    // API Delete SebaranPenyakit
    Route::delete('/sebaran_penyakit/delete/{id}', [SebaranPenyakitController::class, 'delete']);

    // API Get All SebaranPenyakit
    Route::get('/sebaran_penyakit', [SebaranPenyakitController::class, 'index']);

    // API Add SebaranVarietas
    Route::post('/sebaran_varietas/add', [SebaranVarietasController::class, 'store']);

    // API Update SebaranVarietas
    Route::put('/sebaran_varietas/{id}', [SebaranVarietasController::class, 'update']);

    // API Delete SebaranVarietas
    Route::delete('/sebaran_varietas/delete/{id}', [SebaranVarietasController::class, 'delete']);

    // API Get All SebaranVarietas
    Route::get('/sebaran_varietas', [SebaranVarietasController::class, 'index']);

    // API Get All Modul Budidaya
    Route::get('/modul_budidaya', [ModulBudidayaController::class, 'index']);

    // API Get All Modul Budidaya
    Route::get('/modul_budidaya/{category_classes_id}', [ModulBudidayaController::class, 'getVideoModul']);
});
