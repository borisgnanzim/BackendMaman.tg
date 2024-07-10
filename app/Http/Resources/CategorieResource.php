<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
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
            'nom' => $this->nom,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'superCategorie_id' => $this->superCategorie_id,
            'superCategorie' => new CategorieResource($this->whenLoaded('superCategorie')),
            'sousCategories' => CategorieResource::collection($this->whenLoaded('sousCategories')),
            //'articles' => ArticleResource::collection($this->whenLoaded('articles')),
            //'updated_at' => $this->updated_at,
        ];
    }
}
