<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieArticle extends Model
{
    use HasFactory;
    protected $fillable = ['titre','categorie_id', 'article_id'];
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
