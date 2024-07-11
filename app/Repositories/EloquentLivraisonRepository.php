<?php

namespace App\Repositories;

use App\Models\Livraison;

class EloquentLivraisonRepository implements LivraisonRepositoryInterface
{
    public function all()
    {
        return Livraison::with(['commande:id,reference'])->get();
    }
    public function paginate($perPage)
    {
        return Livraison::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Livraison::findOrFail($id);
    }

    public function create(array $data)
    {
        return Livraison::create($data);
    }

    public function update(Livraison $livraison, array $data)
    {
        $livraison->update($data);
        return $livraison;
    }

    public function delete(Livraison $livraison)
    {
        $livraison->delete();
        return response()->json(null, 204);
    }
}
