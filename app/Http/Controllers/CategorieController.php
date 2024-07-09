<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
     * Lister tous les categories
     *
     * @response 200 [
     *   {
     *     "id": 1,
     *     "nom": "Sample Categorie",
     *     "description": "This is a sample desscription."
     *     "super_categorie": "categorie mère"
     * 
     *   }
     * ]
     */
    public function index()
    {
        //
        //return Categorie::all();
        // Récupérer toutes les catégories avec leurs sous-catégories
        $categories = Categorie::whereNull('superCategorie_id')
            ->with('sousCategories')
            ->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieRequest $request)
    {
        //
        $validatedData = $request->validated();

        $categorie = Categorie::create($validatedData);

        return response()->json($categorie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
        return $categorie ;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        //
        $validatedData = $request->validated();

        $categorie->update($validatedData);

        return response()->json($categorie, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
        $categorie->delete();

        return response()->json(null, 204);
    }
    public function getArticles($categorie_id)
    {
        $categorie = Categorie::findOrFail($categorie_id);
        return response()->json($categorie->articles);
    }

}
