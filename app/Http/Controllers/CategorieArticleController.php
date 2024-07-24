<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieArticleRequest;
use App\Http\Requests\UpdateCategorieArticleRequest;
use App\Http\Resources\CategorieArticleResource;
use App\Models\CategorieArticle;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

/**
 * @group CategorieArticle Management
 * 
 * APIs to manage the CategorieArticles ressource
 **/
class CategorieArticleController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategorieArticle::with('categorie','article')->get();
        return $this->successResponse(CategorieArticleResource::collection($categories));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieArticleRequest $request)
    {
        $validateData = $request->validated();
        $categorieArticle = CategorieArticle::create($validateData);
        return $this->successResponse(new CategorieArticleResource($categorieArticle), 'CategorieArticle created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategorieArticle $categorieArticle)
    {
        return $this->successResponse(new CategorieArticleResource($categorieArticle));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieArticleRequest $request, CategorieArticle $categorieArticle)
    {
        $validateData = $request->validated();
        $categorieArticle->update($validateData);
        return $this->successResponse(new CategorieArticleResource($categorieArticle), 'CategorieArticle updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategorieArticle $categorieArticle)
    {
        $categorieArticle->delete();
        return $this->successResponse(null, 'CategorieArticle deleted successfully.', 204);
    }
}
