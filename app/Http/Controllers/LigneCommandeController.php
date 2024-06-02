<?php
namespace App\Http\Controllers;

use App\Models\LigneCommande;
use Illuminate\Http\Request;

class LigneCommandeController extends Controller
{
    public function index()
    {
        return LigneCommande::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
            'article_id' => 'required|exists:articles,id',
            'commande_id' => 'required|exists:commandes,id'
        ]);

        $ligneCommande = LigneCommande::create($validatedData);

        return response()->json($ligneCommande, 201);
    }

    public function show(LigneCommande $ligneCommande)
    {
        return $ligneCommande;
    }

    public function update(Request $request, LigneCommande $ligneCommande)
    {
        $validatedData = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'quantite' => 'sometimes|required|integer',
            'prix' => 'sometimes|required|numeric',
            'article_id' => 'required|exists:articles,id',
            'commande_id' => 'sometimes|required|exists:commandes,id'
        ]);

        $ligneCommande->update($validatedData);

        return response()->json($ligneCommande, 200);
    }

    public function destroy(LigneCommande $ligneCommande)
    {
        $ligneCommande->delete();

        return response()->json(null, 204);
    }
}
