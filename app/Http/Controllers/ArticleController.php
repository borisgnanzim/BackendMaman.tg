<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Article::all();
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
            'ancienPrix' => 'nullable|numeric',
            'prix' => 'required|numeric',
            'quantité' => 'required|integer',
            'categorieArticle_id' => 'required|exists:categories,id'
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
            'ancienPrix' => 'nullable|numeric',
            'prix' => 'sometimes|required|numeric',
            'quantité' => 'sometimes|required|integer',
            'categorieArticle_id' => 'sometimes|required|exists:categories,id'
        ]);

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
}
