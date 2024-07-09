<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLivraisonRequest;
use App\Http\Requests\UpdateLivraisonRequest;
use App\Http\Resources\LivraisonResource;
use App\Repositories\LivraisonRepositoryInterface;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    protected $livraisonRepository;

    public function __construct(LivraisonRepositoryInterface $livraisonRepository)
    {
        $this->livraisonRepository = $livraisonRepository;
    }

    public function index()
    {
        $livraisons = $this->livraisonRepository->all();
        return LivraisonResource::collection($livraisons);
    }

    public function store(StoreLivraisonRequest $request)
    {
        $validatedData = $request->validated();
        $livraison = $this->livraisonRepository->create($validatedData);
        return new LivraisonResource($livraison);
    }

    public function show($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        return new LivraisonResource($livraison);
    }

    public function update(UpdateLivraisonRequest $request, $id)
    {
        $validatedData = $request->validated();
        $livraison = $this->livraisonRepository->find($id);
        $updatedLivraison = $this->livraisonRepository->update($livraison, $validatedData);
        return new LivraisonResource($updatedLivraison);
    }

    public function destroy($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        $this->livraisonRepository->delete($livraison);
        return response()->json(null, 204);
    }

    public function getCommande($livraison_id)
    {
        $livraison = $this->livraisonRepository->find($livraison_id);
        return response()->json($livraison->commande);
    }
}
