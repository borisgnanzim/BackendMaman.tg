<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreLigneCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Http\Requests\UpdateLigneCommandeRequest;
use App\Models\LigneCommande;
use Illuminate\Http\Request;

class LigneCommandeController extends Controller
{
    public function index()
    {
        return LigneCommande::all();
    }

    public function store(StoreLigneCommandeRequest $request)
    {
        $validatedData = $request->validated();

        $ligneCommande = LigneCommande::create($validatedData);

        return response()->json($ligneCommande, 201);
    }

    public function show(LigneCommande $ligneCommande)
    {
        return $ligneCommande;
    }

    public function update(UpdateLigneCommandeRequest $request, LigneCommande $ligneCommande)
    {
        $validatedData = $request->validated();

        $ligneCommande->update($validatedData);

        return response()->json($ligneCommande, 200);
    }

    public function destroy(LigneCommande $ligneCommande)
    {
        $ligneCommande->delete();

        return response()->json(null, 204);
    }
}
