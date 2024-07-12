<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLivraisonRequest;
use App\Http\Requests\UpdateLivraisonRequest;
use App\Http\Resources\LivraisonResource;
use App\Repositories\LivraisonRepositoryInterface;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    use JsonResponseTrait;

    protected $livraisonRepository;

    public function __construct(LivraisonRepositoryInterface $livraisonRepository)
    {
        $this->livraisonRepository = $livraisonRepository;
    }

    // public function index()
    // {
    //     $livraisons = $this->livraisonRepository->all();
    //     return $this->successResponse(LivraisonResource::collection($livraisons));
    // }

    public function index()
    {
        $livraisons = $this->livraisonRepository->paginate(20); // Fetch articles with pagination and sorting
        return $this-> successResponse([
            'articles' =>LivraisonResource::collection($livraisons),
            'links' => [
            'first' => $livraisons->url(1),
            'last' => $livraisons->url($livraisons->lastPage()),
            'prev' => $livraisons->previousPageUrl(),
            'next' => $livraisons->nextPageUrl(),
        ],
        'meta' => [
            'current_page' => $livraisons->currentPage(),
            'from' => $livraisons->firstItem(),
            'last_page' => $livraisons->lastPage(),
            'path' => $livraisons->path(),
            'per_page' => $livraisons->perPage(),
            'to' => $livraisons->lastItem(),
            'total' => $livraisons->total(),
        ]
        ]);
    }


    public function store(StoreLivraisonRequest $request)
    {
        $validatedData = $request->validated();
        $livraison = $this->livraisonRepository->create($validatedData);
        return $this->successResponse(new LivraisonResource($livraison), 'Livraison created successfully.', 201);
    }

    public function show($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        return $this->successResponse(new LivraisonResource($livraison));
    }

    public function update(UpdateLivraisonRequest $request, $id)
    {
        $validatedData = $request->validated();
        $livraison = $this->livraisonRepository->find($id);
        $updatedLivraison = $this->livraisonRepository->update($livraison, $validatedData);
        return $this->successResponse(new LivraisonResource($updatedLivraison), 'Livraison updated successfully.', 200);
    }

    public function destroy($id)
    {
        $livraison = $this->livraisonRepository->find($id);
        $this->livraisonRepository->delete($livraison);
        return $this->successResponse(null, 'Livraison deleted successfully.', 204);
    }

    public function getCommande($livraison_id)
    {
        $livraison = $this->livraisonRepository->find($livraison_id);
        return $this->successResponse($livraison->commande);
    }
}
