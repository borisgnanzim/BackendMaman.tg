<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'solde', 'modePaiment', 'date', 'user_id', 'commande_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
