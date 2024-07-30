<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLivraisonRequest;
use App\Http\Requests\UpdateLivraisonRequest;
use App\Http\Resources\LivraisonResource;
use App\Repositories\LivraisonRepositoryInterface;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;



/**
 * @group Livraison Management
 * 
 * APIs to manage the livraisons ressource
 **/

class LivraisonController extends Controller
{
    use JsonResponseTrait;

    protected $livraisonRepository;

    public function __construct(LivraisonRepositoryInterface $livraisonRepository)
    {
        $this->livraisonRepository = $livraisonRepository;
    }

    public function index()
    {

        return $this->sucessResponseWithPaginate(LivraisonResource::class, $this->livraisonRepository->paginate(20) , 'livraisons');

    }


    public function store(StoreLivraisonRequest $request)
    {
        $validatedData = $request->validated();
        $livraison = $this->livraisonRepository->create($validatedData);
        if ($livraison ==null)
        {
            return $this-> errorResponse("livraison not found");
        }
        return $this->successResponse(new LivraisonResource($livraison), 'Livraison created successfully.', 201);
    }

    public function show($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        if ($livraison ==null)
        {
            return $this-> errorResponse("livraison not found");
        }
        return $this->successResponse(new LivraisonResource($livraison));
    }

    public function update(UpdateLivraisonRequest $request, $id)
    {
        $data = $request->validated();
        $livraison = $this->livraisonRepository->find($id);
        if ($livraison ==null)
        {
            return $this-> errorResponse("livraison not found");
        }
        $updatedLivraison = $this->livraisonRepository->update($data, $id);
        return $this->successResponse(new LivraisonResource($updatedLivraison), 'Livraison updated successfully.', 200);
    }

    public function destroy($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        if ($livraison ==null)
        {
            return $this-> errorResponse("livraison not found");
        }
        $this->livraisonRepository->delete($livraison);
        return $this->successResponse(null, 'Livraison deleted successfully.', 204);
    }

    public function getCommande($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        if ($livraison ==null)
        {
            return $this-> errorResponse("livraison not found");
        }
        return $this->successResponse($livraison->commande);
    }
}
