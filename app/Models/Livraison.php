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
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($livraison) {
            $livraison->reference = static::generateReference();
        });
    }

    protected static function generateReference(): string
    {
        $year = date('y');
        $count = static::whereYear('created_at', date('Y'))->count() + 1;
        $reference = 'LIV' . $year . str_pad($count, 9, '0', STR_PAD_LEFT);
        return $reference;
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
