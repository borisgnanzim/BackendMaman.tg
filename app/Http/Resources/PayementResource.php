<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayementResource extends JsonResource
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
            'reference' => $this->reference,
            'titre' => $this->titre,
            'solde' => $this->solde,
            'modePayement' => $this->modePayement,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'user' => [
                'id' => $this->user_id,
                'nom_complet' => $this->user->nom . ' ' . $this->user->prenom,
            ],
            'commande' => [
                'id' => $this->commande_id,
                'reference' => $this->commande->reference,
            ],
            //'updated_at' => $this->updated_at,
        ];
    }
}
