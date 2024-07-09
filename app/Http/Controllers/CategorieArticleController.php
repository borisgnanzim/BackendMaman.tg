<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieArticleRequest;
use App\Http\Requests\UpdateCategorieArticleRequest;
use App\Models\CategorieArticle;
use Illuminate\Http\Request;

class CategorieArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return CategorieArticle::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieArticleRequest $request)
    {
        //
        $validateData = $request->validated();
        $categorieArticle = CategorieArticle::create($validateData);
        return response()->json($categorieArticle, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategorieArticle $categorieArticle)
    {
        //
        return $categorieArticle;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieArticleRequest $request, CategorieArticle $categorieArticle)
    {
        //
        $validateData = $request->validated();
        $categorieArticle -> update($validateData);
        return response()->json($categorieArticle, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategorieArticle $categorieArticle)
    {
        //
        $categorieArticle ->delete();
        return response()->json(null, 204);
    }
}
