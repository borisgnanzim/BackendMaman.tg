<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Categorie;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Resources\CategorieResource;

/**
 * @group Catégorie Management
 * 
 * APIs to manage the catégorie ressource
 **/

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
        return $this->successResponse(new CategorieResource(Categorie::create($request->all())), 'Categorie created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorie = Categorie::find($id) ;
        if ($categorie == null)
        {
            return $this->errorResponse("Categorie not found");
        }
        $categorie->load('superCategorie', 'sousCategories');
        return $this->successResponse(new CategorieResource($categorie));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, $id)
    {
        $validatedData = $request->all();
        $categorie = Categorie::find($id) ;
        if ($categorie == null)
        {
            return $this->errorResponse("Categorie not found");
        }
        $categorie->update($validatedData);
        return $this->successResponse(new CategorieResource($categorie), 'Categorie updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = Categorie::find($id) ;
        if ($categorie == null)
        {
            return $this->errorResponse("Categorie not found");
        }
        $categorie->delete();
        return $this->successResponse(null, 'Categorie deleted successfully.', 204);
    }

    public function getArticles($id)
    {
        $categorie = Categorie::findOrFail($id);
        return $this->successResponse(ArticleResource::collection($categorie->articles));
    }
}
