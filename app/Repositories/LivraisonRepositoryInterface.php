<?php

namespace App\Repositories;

use App\Models\Livraison;

interface LivraisonRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Livraison $livraison, array $data);
    public function delete(Livraison $livraison);
}
