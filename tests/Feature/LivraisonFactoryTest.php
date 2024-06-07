<?php
// tests/Feature/LivraisonFactoryTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livraison;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivraisonFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_livraison_factory_creates_a_livraison()
    {
        // Utilise la factory pour créer une instance de Livraison
        $livraison = Livraison::factory()->create();

        // Vérifie que l'enregistrement a été inséré dans la base de données
        $this->assertDatabaseHas('livraisons', [
            'id' => $livraison->id,
            'reference' => $livraison->reference,
            'titre' => $livraison->titre,
            'date' => $livraison->date,
            'nomClient' => $livraison->nomClient,
            'adresse' => $livraison->adresse,
            'commande_id' => $livraison->commande_id,
        ]);

        // Vérifie que l'instance créée est une instance de Livraison
        $this->assertInstanceOf(Livraison::class, $livraison);
    }
}
