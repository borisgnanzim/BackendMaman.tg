<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        return Commande::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'montant' => 'required|numeric',
            'statut' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        $commande = Commande::create($validatedData);

        return response()->json($commande, 201);
    }

    public function show(Commande $commande)
    {
        return $commande;
    }

    public function update(Request $request, Commande $commande)
    {
        $validatedData = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'montant' => 'sometimes|required|numeric',
            'statut' => 'sometimes|required|string|max:255',
            'reference' => 'sometimes|required|string|max:255',
            'user_id' => 'sometimes|required|exists:users,id'
        ]);

        $commande->update($validatedData);

        return response()->json($commande, 200);
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();

        return response()->json(null, 204);
    }
}
