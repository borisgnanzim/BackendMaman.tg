<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'description', 'superCategorie_id'
    ];

    /**
     * Obtenez la super catégorie de la catégorie.
     */
    public function superCategorie()
    {
        return $this->belongsTo(Categorie::class, 'superCategorie_id');
    }

    /**
     * Obtenez les sous-catégories de la catégorie.
     */
    public function sousCategories()
    {
        return $this->hasMany(Categorie::class, 'superCategorie_id');
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'categorie_articles');
    }

}
