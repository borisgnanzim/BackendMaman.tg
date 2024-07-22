<?php

namespace App\Repositories;

use App\Models\Livraison;

class EloquentLivraisonRepository implements LivraisonRepositoryInterface
{
    public function all()
    { 
        return Livraison::with(['commande'])->get();
    }
    public function paginate($perPage)
    {
        return Livraison::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Livraison::find($id);
    }

    public function create(array $data)
    {
        return Livraison::create($data);
    }

    public function update(array $data , $id)
    {
        $livraison = Livraison::find($id);
        $livraison->update($data);
        return $livraison;
    }

    public function delete($id)
    {
        $livraison = Livraison::findOrFail($id);
        $livraison->delete();
        return response()->json(null, 204);
    }
}
