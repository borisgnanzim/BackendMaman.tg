<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'mini_description' => $this->mini_description,
            'ancienPrix' => $this->ancienPrix,
            'prix' => $this->prix,
            'quantite' => $this->quantite,
            'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'categories' => CategorieResource::collection($this->whenLoaded('categories')),
        ];
    }
}
