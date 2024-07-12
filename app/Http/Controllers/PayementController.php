<?php

namespace App\Http\Controllers;

use App\Events\PayementReceived;
use App\Http\Requests\StorePayementRequest;
use App\Http\Requests\UpdatePayementRequest;
use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\JsonResponseTrait;
use App\Http\Resources\PayementResource;

class PayementController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        // Récupérer tous les paiements avec les informations utilisateur et commande
        $payements = Payement::with(['user', 'commande'])->orderBy('created_at', 'desc')->paginate(20);
        
        return $this-> successResponse([
            'articles' =>PayementResource::collection($payements),
            'links' => [
            'first' => $payements->url(1),
            'last' => $payements->url($payements->lastPage()),
            'prev' => $payements->previousPageUrl(),
            'next' => $payements->nextPageUrl(),
        ],
        'meta' => [
            'current_page' => $payements->currentPage(),
            'from' => $payements->firstItem(),
            'last_page' => $payements->lastPage(),
            'path' => $payements->path(),
            'per_page' => $payements->perPage(),
            'to' => $payements->lastItem(),
            'total' => $payements->total(),
        ]
        ]);       
    }

    public function store(StorePayementRequest $request)
    {
        $validatedData = $request->validated();

        $payement = Payement::create($validatedData);
        event(new PayementReceived($payement->commande_id));

        return $this->successResponse(new PayementResource($payement), 'Payment received and status updated.', 201);
    }

    public function show(Payement $payement)
    {
        return $this->successResponse(new PayementResource($payement));
    }

    public function update(UpdatePayementRequest $request, Payement $payement)
    {
        $validatedData = $request->validated();

        $payement->update($validatedData);

        return $this->successResponse(new PayementResource($payement), 'Payment updated successfully', 200);
    }

    public function destroy(Payement $payement)
    {
        $payement->delete();

        return $this->successResponse(null, 'Payment deleted successfully', 204);
    }
}
