<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'date', 'montant', 'statut', 'reference', 'latitude', 'longitude', 'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lignesCommande()
    {
        return $this->hasMany(LigneCommande::class);
    }
    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }
}
