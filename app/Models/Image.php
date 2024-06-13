<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Image extends Model
{
    use HasFactory;

    protected $fillable = ['titre','path','description', 'article_id'];

    // Ajouter un attribut append pour inclure l'URL dans les réponses JSON
    protected $appends = ['url'];

    // Accessor pour l'URL publique de l'image
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
