<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'quantité', 'prix', 'article_id', 'commande_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
