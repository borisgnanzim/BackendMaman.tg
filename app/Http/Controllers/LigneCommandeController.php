<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLigneCommandeRequest;
use App\Http\Requests\UpdateLigneCommandeRequest;
use App\Models\LigneCommande;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Resources\LigneCommandeResource;

class LigneCommandeController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        // Fetch ligneCommandes with pagination, ordered by creation date in descending order
        $ligneCommandes = LigneCommande::orderBy('created_at', 'desc')->paginate(20);

        return $this->sucessResponseWithPaginate(LigneCommandeResource::class, $ligneCommandes,'ligneCommandes');
    }

    public function store(StoreLigneCommandeRequest $request)
    {
        $validatedData = $request->validated();
        $ligneCommande = LigneCommande::create($validatedData);
        return $this->successResponse(new LigneCommandeResource($ligneCommande), 'LigneCommande created successfully.', 201);
    }

    public function show(LigneCommande $ligneCommande)
    {
        return $this->successResponse(new LigneCommandeResource($ligneCommande));
    }

    public function update(UpdateLigneCommandeRequest $request, LigneCommande $ligneCommande)
    {
        $validatedData = $request->validated();
        $ligneCommande->update($validatedData);
        return $this->successResponse(new LigneCommandeResource($ligneCommande), 'LigneCommande updated successfully.', 200);
    }

    public function destroy(LigneCommande $ligneCommande)
    {
        $ligneCommande->delete();
        return $this->successResponse(null, 'LigneCommande deleted successfully.', 204);
    }
}
