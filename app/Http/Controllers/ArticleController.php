<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
/**
 * @group Articles
 *
 * API pour gérer les articles
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Lister tous les articles
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "nom": "Sample Article",
     *     "description": "This is a sample article."
     * 
     *   }
     * ]
     */
    public function index()
    {
        //
        //return Article::all();
        $articles = Article::with('images')->get();
        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mini_description' => 'nullable|string',
            // 'ancienPrix' => 'nullable|numeric',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            //'categorieArticle_id' => 'required|exists:categories,id'
        ]);

        $article = Article::create($validatedData);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
        // Charger les images avec l'article
        $article->load('images');
        return $article;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
        $validatedData = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'mini_description' => 'nullable|string',
            //'ancienPrix' => 'nullable|numeric',
            'prix' => 'sometimes|required|numeric',
            'quantite' => 'sometimes|required|integer',
            //'categorieArticle_id' => 'sometimes|required|exists:categories,id'
        ]);
        // Vérifiez si le prix a changé
        if ($request->has('prix') && $article->prix != $validatedData['prix']) {
            // Mettre à jour ancienPrix avec la valeur actuelle de prix
            $article->ancienPrix = $article->prix;
        }
        $article->update($validatedData);

        return response()->json($article, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article )
    {
        //
        $article->delete();

        return response()->json(null, 204);
    }

    public function getImages($article_id)
    {
        // $article = Article::findOrFail($article_id);
        // return response()->json($article->images);

        $article = Article::findOrFail($article_id);
        $images = $article->images()->get();

        // L'URL publique est déjà ajoutée par l'accessor dans le modèle Image
        return response()->json($images);
    }

    public function getCategories($article_id)
    {
        $article = Article::findOrFail($article_id);
        return response()->json($article->categories);
    }
}
