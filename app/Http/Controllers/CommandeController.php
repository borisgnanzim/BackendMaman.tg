<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Traits\JsonResponseTrait;
use App\Http\Resources\CommandeResource;
use App\Http\Resources\LigneCommandeResource;

class CommandeController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        $commandes = Commande::with(['user','lignecommandes'])->orderBy('created_at', 'desc')->paginate(20);
        return $this-> successResponse([
            'articles' =>CommandeResource::collection($commandes),
            'links' => [
                'first' => $commandes->url(1),
                'last' => $commandes->url($commandes->lastPage()),
                'prev' => $commandes->previousPageUrl(),
                'next' => $commandes->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $commandes->currentPage(),
                'from' => $commandes->firstItem(),
                'last_page' => $commandes->lastPage(),
                'path' => $commandes->path(),
                'per_page' => $commandes->perPage(),
                'to' => $commandes->lastItem(),
                'total' => $commandes->total(),
            ]
        ]);
        
    }

    // public function index()
    // {
    //     $commandes = Commande::with(['user','lignecommandes'])->get();
    //     return $this->successResponse(CommandeResource::collection($commandes));
    // }

    public function store(StoreCommandeRequest $request)
    {
        $validatedData = $request->validated();
        foreach ($validatedData['articles'] as $articleData) {
            $article = Article::find($articleData['article_id']);
            if ($article->quantite < $articleData['quantite']) {
                return $this->errorResponse(
                    "Quantité demandée supérieure à la quantité disponible pour l\'article: " . $article->nom,
                    400,
                    ['article_titre' => $article->titre, 'quantite_disponible' => $article->quantite]
                );
            }
        }

        $commande = Commande::create([
            'titre' => $validatedData['titre'],
            'date' => $validatedData['date'],
            'montant' => $validatedData['montant'],
            'statut' => $validatedData['statut'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'user_id' => Auth::id(),
        ]);

        foreach ($validatedData['articles'] as $articleData) {
            $article = Article::find($articleData['article_id']);
            LigneCommande::create([
                'commande_id' => $commande->id,
                'article_id' => $articleData['article_id'],
                'quantite' => $articleData['quantite'],
                'titre' => $article->nom,
                'prix' => $article->prix,
            ]);
            $article->quantite -= $articleData['quantite'];
            $article->save();
        }

        return $this->successResponse(new CommandeResource($commande), 'Commande created successfully.', 201);
    }

    public function show(Commande $commande)
    {
        return $this->successResponse(new CommandeResource($commande));
    }

    public function update(UpdateCommandeRequest $request, Commande $commande)
    {
        $validatedData = $request->validated();
        $commande->update($validatedData + ['user_id' => Auth::id()]);
        return $this->successResponse(new CommandeResource($commande), 'Commande updated successfully.', 200);
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();
        return $this->successResponse(null, 'Commande deleted successfully.', 204);
    }

    public function getLignesCommande($categorie_id)
    {
        $commande = Commande::findOrFail($categorie_id);
        return $this->successResponse(LigneCommandeResource::collection($commande->lignesCommande));
    }
}
