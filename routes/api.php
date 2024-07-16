<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\PasswordResetController;
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
//
use App\Http\Controllers\Auth\AuthController;

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

// Route::apiResource('categories', CategorieController::class);
// Route::apiResource('categorieArticles', CategorieArticleController::class);
// Route::apiResource('articles', ArticleController::class);
// Route::apiResource('images', ImageController::class);
// Route::apiResource('ligneCommandes', LigneCommandeController::class);
// Route::apiResource('commandes', CommandeController::class);
// Route::apiResource('payements', PayementController::class);
// Route::apiResource('users', UserController::class);
// Route::apiResource('livraisons', LivraisonController::class);
//
// Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download');
// //
// Route::get('articles/{article}/images', [ArticleController::class, 'getImages'])->name('articles.images');
// //
// Route::get('articles/{article}/categories', [ArticleController::class, 'getCategories'])->name('articles.categories');

// Route::get('categories/{categorie}/articles',[CategorieController::class, 'getArticles'])->name('categorie.articles');

// Route::get('commandes/{commande}/lignescommande',[CommandeController::class, 'getLignesCommande'])->name('commande.lignescommande');

// Route::get('livraisons/{livraison}/commande',[LivraisonController::class,'getCommande'])->name('livraison.commande');


//
// Groupes de routes pour les administrateurs
    Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    //Route::resource('articles', ArticleController::class);

    //
    Route::apiResource('categories', CategorieController::class);
    Route::apiResource('categorieArticles', CategorieArticleController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('images', ImageController::class);
    Route::apiResource('ligneCommandes', LigneCommandeController::class);
    Route::apiResource('commandes', CommandeController::class);
    Route::apiResource('payements', PayementController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('livraisons', LivraisonController::class);

    Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download');
    //
    Route::get('articles/{article}/images', [ArticleController::class, 'getImages'])->name('articles.images');
    //
    Route::get('articles/{article}/categories', [ArticleController::class, 'getCategories'])->name('articles.categories');

    Route::get('categories/{categorie}/articles',[CategorieController::class, 'getArticles'])->name('categorie.articles');

    Route::get('commandes/{commande}/lignescommande',[CommandeController::class, 'getLignesCommande'])->name('commande.lignescommande');

    Route::get('livraisons/{livraison}/commande',[LivraisonController::class,'getCommande'])->name('livraison.commande');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    //
});

Route::middleware(['auth:sanctum','role:user'])->group(function () {
   // Route::get('/profile', [UserController::class, 'show']);
    //
   Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);

    Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download.forRoleUser');
//
    Route::get('articles/{article}/images', [ArticleController::class, 'getImages'])->name('articles.images.forRoleUser');
//
    Route::get('articles/{article}/categories', [ArticleController::class, 'getCategories'])->name('articles.categories.forRoleUser');

    Route::get('categories/{categorie}/articles',[CategorieController::class, 'getArticles'])->name('categorie.articles.forRoleUser');

    Route::apiResource('commandes', CommandeController::class);

    //Route::post('/commandes', [CommandeController::class, 'store'])->name('post.commande.forRoleUser');

    Route::post('/lignecommandes',[LigneCommandeController::class,'store'])->name('post.ligneCommandes.forRoleUser');

    Route::post('/payements',[PayementController::class, 'store'])->name('post.payements.forRoleUser');

    Route::get('/images/{image}', [ImageController::class, 'show'])->name('get.image.forRoleUser');
    //
    

});

// route public

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);

Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download');
//
Route::get('articles/{article}/images', [ArticleController::class, 'getImages'])->name('articles.images');
//
Route::get('articles/{article}/categories', [ArticleController::class, 'getCategories'])->name('articles.categories');

Route::get('categories/{categorie}/articles',[CategorieController::class, 'getArticles'])->name('categorie.articles');

Route::get('/categories',[CategorieController::class,'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Route::apiResource('images', ImageController::class);
Route::get('/images/{image}', [ImageController::class, 'show']);


// temp
    // Route::apiResource('categories', CategorieController::class);
    // Route::apiResource('categorieArticles', CategorieArticleController::class);
    // Route::apiResource('articles', ArticleController::class);
    // Route::apiResource('images', ImageController::class);
    // Route::apiResource('ligneCommandes', LigneCommandeController::class);
    // Route::apiResource('commandes', CommandeController::class);
    // Route::apiResource('payements', PayementController::class);
    // Route::apiResource('users', UserController::class);
    // Route::apiResource('livraisons', LivraisonController::class);
    // Route::post('/commandes', [CommandeController::class, 'store']);
    // Route::post('/lignecommandes',[LigneCommandeController::class,'store']);
    // Route::post('/payements',[PayementController::class, 'store']);
// temp

// routes pour mot de passe oublié 
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [PasswordResetController::class, 'reset']);

//