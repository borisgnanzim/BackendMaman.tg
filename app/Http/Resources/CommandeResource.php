<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeResource extends JsonResource
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
            'date' => $this->date,
            'montant' => $this->montant,
            'statut' => $this->statut,
            'reference' => $this->reference,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at,
            'user' => [
                'nom' => $this->user->nom,
                'prenom' => $this->user->prenom,
                'adresse' => $this->user->adresse,
                'email' => $this->user->email,
            ],
            'lignesCommande' => LigneCommandeResource::collection($this->whenLoaded('lignesCommande')),
            //'updated_at' => $this->updated_at,
        ];
    }
}
