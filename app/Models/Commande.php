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
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            $commande->reference = static::generateReference();
        });
    }

    protected static function generateReference(): string
    {
        $year = date('y');
        $count = static::whereYear('created_at', date('Y'))->count() + 1;
        $reference = 'CMD' . $year . str_pad($count, 9, '0', STR_PAD_LEFT);
        return $reference;
    }
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
