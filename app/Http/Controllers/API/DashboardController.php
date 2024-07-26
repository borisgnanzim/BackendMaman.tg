<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Livraison;
use App\Models\Payement;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function getStatistics()
    {
        $userCount = User::count();
        $articleCount = Article::count();
        $commandeCount = Commande::count();
        $categorieCount = Categorie::count();
        $livraisonCount = Livraison::count();
        $payementCount = Payement::count();

        return response()->json([
            'user_count' => $userCount,
            'article_count' => $articleCount,
            'commande_count' => $commandeCount,
            'categorie_count' => $categorieCount,
            'livraison_count' => $livraisonCount,
            'payement_count' => $payementCount,
        ]);
    }
}
