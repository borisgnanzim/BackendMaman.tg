<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $commandes = Commande::with(['user', 'lignecommandes'])->orderBy('created_at', 'desc')->paginate(20);
        return $this->sucessResponseWithPaginate(CommandeResource::class, $commandes, 'commandes');
    }

    public function store(StoreCommandeRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            // Vérification des quantités disponibles
            foreach ($validatedData['articles'] as $articleData) {
                $article = Article::findOrFail($articleData['article_id']);
                if ($article->quantite < $articleData['quantite']) {
                    return $this->errorResponse(
                        "Quantité demandée supérieure à la quantité disponible pour l'article: " . $article->nom,
                        400,
                        ['article_titre' => $article->nom, 'quantite_disponible' => $article->quantite]
                    );
                }
            }

            // Création de la commande
            $commande = Commande::create([
                'titre' => $validatedData['titre'],
                'date' => $validatedData['date'],
                'montant' => $validatedData['montant'],
                'statut' => 'attente',
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'user_id' => Auth::id(),
            ]);
            // Création des lignes de commande et mise à jour des quantités des articles
            foreach ($validatedData['articles'] as $articleData) {
                $article = Article::findOrFail($articleData['article_id']);
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

            DB::commit();
            return $this->successResponse(new CommandeResource($commande), 'Commande created successfully.', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('An error occurred while creating the order.', 500, ['error' => $e->getMessage()]);
        }
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

    public function getLignesCommande($commande_id)
    {
        $commande = Commande::findOrFail($commande_id);
        return $this->successResponse(LigneCommandeResource::collection($commande->lignecommandes));
    }
}
