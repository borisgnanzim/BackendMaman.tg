<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;class CommandeController extends Controller
{
    public function index()
    {
        // $commandes = Commande::with('user')->get();
        // return response()->json($commandes);
        // Récupérer toutes les commandes avec les informations spécifiques de l'utilisateur
    $commandes = Commande::with(['user:id,nom,prenom,adresse,email'])->get();

    // Transformer les données pour inclure uniquement les attributs nécessaires de l'utilisateur
    $commandes = $commandes->map(function($commande) {
        return [
            'id' => $commande->id,
            'titre' => $commande->titre,
            'date' => $commande->date,
            'montant' => $commande->montant,
            'statut' => $commande->statut,
            'reference' => $commande->reference,
            'latitude' => $commande->latitude,
            'longitude' => $commande->longitude,
            'user' => [
                'nom' => $commande->user->nom,
                'prenom' => $commande->user->prenom,
                'adresse' => $commande->user->adresse,
                'email' => $commande->user->email,
            ]
        ];
    });

    return response()->json($commandes);
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'titre' => 'required|string|max:255',
    //         'date' => 'required|date',
    //         'montant' => 'required|numeric',
    //         'statut' => 'required|string|max:255',
    //         'reference' => 'required|string|max:255',
    //         'user_id' => 'required|exists:users,id'
    //     ]);

    //     $commande = Commande::create($validatedData);

    //     return response()->json($commande, 201);
    // }
    public function store(StoreCommandeRequest $request)
    {
        // Validation de la commande
        // $validatedData = $request->validate([
        //     'titre' => 'required|string|max:255',
        //     'date' => 'required|date',
        //     'montant' => 'required|numeric',
        //     'statut' => 'required|string|max:25',
        //     'latitude' => 'nullable|numeric',
        //     'longitude' => 'nullable|numeric',
        //     'articles' => 'required|array',
        //     'articles.*.article_id' => 'required|exists:articles,id',
        //     'articles.*.quantite' => 'required|integer|min=1',
        // ]);
        $validatedData = $request->validated();

        // Parcourir les articles commandés pour vérifier les quantités
        foreach ($validatedData['articles'] as $articleData) {
            $article = Article::find($articleData['article_id']);
            
            // Vérifiez si la quantité demandée est disponible
            if ($article->quantite < $articleData['quantite']) {
                return response()->json([
                    'message' => 'Quantité demandée supérieure à la quantité disponible pour l\'article: ' . $article->nom,
                    'article_id' => $article->id,
                    'quantite_disponible' => $article->quantite,
                ], 400);
            }
        }

        // Création de la commande
        $commande = Commande::create([
            'titre' => $validatedData['titre'],
            'date' => $validatedData['date'],
            'montant' => $validatedData['montant'],
            'statut' => $validatedData['statut'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'user_id' => Auth::id(),
        ]);

        // Parcourir les articles commandés pour créer les lignes de commande et mettre à jour les quantités
        foreach ($validatedData['articles'] as $articleData) {
            $article = Article::find($articleData['article_id']);
            
            // Créez la ligne de commande
            LigneCommande::create([
                'commande_id' => $commande->id,
                'article_id' => $articleData['article_id'],
                'quantite' => $articleData['quantite'],
                'titre' => $article->nom,
                'prix' => $article->prix,
            ]);

            // Mettez à jour la quantité disponible de l'article
            $article->quantite -= $articleData['quantite'];
            $article->save();
        }

        return response()->json($commande, 201);
    }

    public function show(Commande $commande)
    {
        return $commande;
    }

    public function update(UpdateCommandeRequest $request, Commande $commande)
    {
        
        $validatedData = $request->validated();

        $commande->update($validatedData + ['user_id' => Auth::id()]);
        
        return response()->json($commande, 200);
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();

        return response()->json(null, 204);
    }
    
    public function getLignesCommande($categorie_id)
    {
        $commande = Commande::findOrFail($categorie_id);
        return response()->json($commande->lignesCommande);
    }
}
