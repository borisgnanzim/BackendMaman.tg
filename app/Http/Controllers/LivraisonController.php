<?php
namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    public function index()
    {
        return Livraison::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'nomClient' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255', // Permettre à ville d'être null
            'adresse' => 'required|string|max:255',
            'reference' => 'sometimes|required|string|max:255',
            'commande_id' => 'required|exists:commandes,id'
        ]);

        $livraison = Livraison::create($validatedData);

        return response()->json($livraison, 201);
    }

    public function show(Livraison $livraison)
    {
        return $livraison;
    }

    public function update(Request $request, Livraison $livraison)
    {
        $validatedData = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'nomClient' => 'sometimes|required|string|max:255',
            'ville' => 'nullable|string|max:255', // Permettre à ville d'être null
            'adresse' => 'sometimes|required|string|max:255',
            'reference' => 'sometimes|required|string|max:255',
            'commande_id' => 'sometimes|required|exists:commandes,id'
        ]);

        $livraison->update($validatedData);

        return response()->json($livraison, 200);
    }

    public function destroy(Livraison $livraison)
    {
        $livraison->delete();

        return response()->json(null, 204);
    }

    public function getCommande($livraison_id)
    {
        $livraison = Livraison::findOrFail($livraison_id);

        return response()->json($livraison->commande);
    }
}
