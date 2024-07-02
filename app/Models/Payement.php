<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'solde', 'modePayement', 'date', 'reference','user_id', 'commande_id'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payement) {
            $payement->reference = static::generateReference();
        });
    }

    protected static function generateReference(): string
    {
        $year = date('y');
        $count = static::whereYear('created_at', date('Y'))->count() + 1;
        $reference = 'PAY' . $year . str_pad($count, 9, '0', STR_PAD_LEFT);
        return $reference;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
