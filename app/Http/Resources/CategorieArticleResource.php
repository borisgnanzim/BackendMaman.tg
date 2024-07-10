<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieArticleResource extends JsonResource
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
            'titre'=>$this->titre,
            'date_de_creation'=> $this->created_at,
            'categorie'=>[
                'id' =>$this -> categorie->id,
                'nom' =>$this -> categorie ->nom,
            ],
            'article'=>[
                'id' =>$this->article->id,
                'nom' => $this->article->nom,
            ],
        ];
    }
}
