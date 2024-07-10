<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Categorie;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Resources\CategorieResource;

class CategorieController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::whereNull('superCategorie_id')
            ->with('sousCategories')
            ->get();
        return $this->successResponse(CategorieResource::collection($categories));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieRequest $request)
    {
        $validatedData = $request->validated();
        $categorie = Categorie::create($validatedData);
        return $this->successResponse(new CategorieResource($categorie), 'Categorie created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        return $this->successResponse(new CategorieResource($categorie));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        $validatedData = $request->validated();
        $categorie->update($validatedData);
        return $this->successResponse(new CategorieResource($categorie), 'Categorie updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return $this->successResponse(null, 'Categorie deleted successfully.', 204);
    }

    public function getArticles($categorie_id)
    {
        $categorie = Categorie::findOrFail($categorie_id);
        return $this->successResponse(ArticleResource::collection($categorie->articles));
    }
}
