<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'description','mini_description', 'ancienPrix', 'prix', 'quantite'
    ];
     // Define the relationship with Image
     public function images()
     {
        return $this->hasMany(Image::class);
     }
 
     // Define the relationship with Categorie
     public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'categorie_articles');
    }
    // public function categorieArticles()
    // {
    //     return $this->hasMany(CategorieArticle::class, 'categorieArticle_id');
    // }
 
     // Define the relationship with LigneCommande
     public function ligneCommandes()
     {
        return $this->hasMany(LigneCommande::class);
     }
}
