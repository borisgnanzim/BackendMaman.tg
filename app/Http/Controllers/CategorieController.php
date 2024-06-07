<?php

namespace App\Http\Controllers;

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
        return Categorie::all();
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
            'super_categorie' => 'nullable|exists:categories,id'
        ]);

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
    public function update(Request $request, Categorie $categorie)
    {
        //
        $validatedData = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'super_categorie' => 'nullable|exists:categories,id'
        ]);

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
