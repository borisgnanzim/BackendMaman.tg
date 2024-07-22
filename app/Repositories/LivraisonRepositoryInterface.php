<?php

namespace App\Repositories;

//use App\Models\Livraison;

interface LivraisonRepositoryInterface
{
    public function all();
    public function find($id);
    public function paginate($perPage);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
