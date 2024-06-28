<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'date', 'nomClient','ville', 'adresse','destinataire','reference', 'commande_id'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
