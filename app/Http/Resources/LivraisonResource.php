<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivraisonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'date' => $this->date,
            'nomClient' => $this->nomClient,
            'ville' => $this->ville,
            'adresse' => $this->adresse,
            'reference' => $this->reference,
            'destinataire' => $this->destinataire,
            'commande' => [
                'commande_id' => $this->commande->id,
                'commande_reference' => $this->commande->reference,
            ],
        ];
    }
}
