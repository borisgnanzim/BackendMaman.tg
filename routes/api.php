<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LigneCommandeController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\PayementController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('categories', CategorieController::class);
Route::apiResource('categorieArticles', CategorieArticleController::class);
Route::apiResource('articles', ArticleController::class);
Route::apiResource('images', ImageController::class);
Route::apiResource('ligneCommandes', LigneCommandeController::class);
Route::apiResource('commandes', CommandeController::class);
Route::apiResource('payements', PayementController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('livraisons', LivraisonController::class);
//
Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download');
