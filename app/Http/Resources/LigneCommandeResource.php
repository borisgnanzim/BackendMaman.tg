<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LigneCommandeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'quantite' => $this->quantite,
            'prix' => $this->prix,
            'article' => [
                'id' => $this->article->id,
                'nom' => $this->article->nom
            ],
           'commande' => [ 
            'id' => $this->id,
            'reference' => $this->commande->reference, 
           ],
            'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ];
    }
}
