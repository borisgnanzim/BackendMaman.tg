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

    //
    //Route::apiResource('categories', CategorieController::class);
    //Route::apiResource('categorieArticles', CategorieArticleController::class);
    //Route::apiResource('articles', ArticleController::class);
    //Route::apiResource('images', ImageController::class);
    //Route::apiResource('ligneCommandes', LigneCommandeController::class);
    //Route::apiResource('commandes', CommandeController::class);
    //Route::apiResource('payements', PayementController::class);
    //Route::apiResource('users', UserController::class);
    //Route::apiResource('livraisons', LivraisonController::class);

    //
    Route::prefix('admin.categories')->name('admin.categories')->group(function () {
        Route::get('/', [CategorieController::class, 'index']);
        Route::get('/{id}', [CategorieController::class, 'show']);
        Route::post('/', [CategorieController::class, 'store']);
        Route::put('/{id}', [CategorieController::class, 'update']);
        Route::delete('/{id}', [CategorieController::class, 'destroy']);
    });

    Route::prefix('admin.categorieArticles')->name('admin.categorieArticles')->group(function () {
        Route::get('/', [CategorieArticleController::class, 'index']);
        Route::get('/{id}', [CategorieArticleController::class, 'show']);
        Route::post('/', [CategorieArticleController::class, 'store']);
        Route::put('/{id}', [CategorieArticleController::class, 'update']);
        Route::delete('/{id}', [CategorieArticleController::class, 'destroy']); 
    });

    Route::prefix('admin.articles')->name('admin.articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/{id}', [ArticleController::class, 'show']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::put('/{id}', [ArticleController::class, 'update']);
        Route::delete('/{id}', [ArticleController::class, 'destroy']); 
    });

    Route::prefix('admin.images')->name('admin.images')->group(function () {
        Route::get('/', [ImageController::class, 'index']);
        Route::get('/{id}', [ImageController::class, 'show']);
        Route::post('/', [ImageController::class, 'store']);
        Route::put('/{id}', [ImageController::class, 'update']);
        Route::delete('/{id}', [ImageController::class, 'destroy']); 
    });
    

    Route::prefix('admin.ligneCommandes')->name('admin.ligneCommandes')->group(function () {
        Route::get('/', [LigneCommandeController::class, 'index']);
        Route::get('/{id}', [LigneCommandeController::class, 'show']);
        Route::post('/', [LigneCommandeController::class, 'store']);
        Route::put('/{id}', [LigneCommandeController::class, 'update']);
        Route::delete('/{id}', [LigneCommandeController::class, 'destroy']); 
    });   

    Route::prefix('admin.users')->name('admin.users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']); 
    });
    Route::prefix('admin.livraisons')->name('admin.livraisons')->group(function () {
        Route::get('/', [LivraisonController::class, 'index']);
        Route::get('/{id}', [LivraisonController::class, 'show']);
        Route::post('/', [LivraisonController::class, 'store']);
        Route::put('/{id}', [LivraisonController::class, 'update']);
        Route::delete('/{id}', [LivraisonController::class, 'destroy']); 
    });

    Route::prefix('admin.commandes')->name('admin.commandes')->group(function () {
        Route::get('/', [CommandeController::class, 'index']);
        Route::get('/{id}', [CommandeController::class, 'show']);
        Route::post('/', [CommandeController::class, 'store']);
        Route::put('/{id}', [CommandeController::class, 'update']);
        Route::delete('/{id}', [CommandeController::class, 'destroy']); 
    });

    Route::prefix('admin.payements')->name('admin.payements')->group(function () {
        Route::get('/', [PayementController::class, 'index']);
        Route::get('/{id}', [PayementController::class, 'show']);
        Route::post('/', [PayementController::class, 'store']);
        Route::put('/{id}', [PayementController::class, 'update']);
        Route::delete('/{id}', [PayementController::class, 'destroy']); 
    });

    //

    Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download');
    //
    Route::get('articles/{article}/images', [ArticleController::class, 'getImages'])->name('articles.images');
    //
    Route::get('articles/{article}/categories', [ArticleController::class, 'getCategories'])->name('articles.categories');

    Route::get('categories/{categorie}/articles',[CategorieController::class, 'getArticles'])->name('categorie.articles');

    Route::get('commandes/{commande}/lignescommande',[CommandeController::class, 'getLignesCommande'])->name('commande.lignescommande');

    Route::get('livraisons/{livraison}/commande',[LivraisonController::class,'getCommande'])->name('livraison.commande');

    Route::get('/profiles', [AuthController::class, 'profile'])->name('admin.profile');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    

    //
});

Route::middleware(['auth:sanctum','role:user'])->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);
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

    //Route::apiResource('commandes', CommandeController::class);

    Route::post('/commandes', [CommandeController::class, 'store'])->name('post.commande.forRoleUser');

    Route::post('/lignecommandes',[LigneCommandeController::class,'store'])->name('post.ligneCommandes.forRoleUser');

    Route::post('/payements',[PayementController::class, 'store'])->name('post.payements.forRoleUser');

    Route::get('/images/{image}', [ImageController::class, 'show'])->name('get.image.forRoleUser');
    //
    

});

// route public

Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/articles/{article}', [ArticleController::class, 'show']);

Route::get('images/{image}/download', [ImageController::class, 'download'])->name('images.download');
//
Route::get('articles/{article}/images', [ArticleController::class, 'getImages'])->name('articles.images');
//
Route::get('articles/{article}/categories', [ArticleController::class, 'getCategories'])->name('articles.categories');

Route::get('categories/{id}/articles',[CategorieController::class, 'getArticles'])->name('categorie.articles');

Route::get('/categories',[CategorieController::class,'index']);

Route::get('/categories/{id}',[CategorieController::class,'show']);

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);

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