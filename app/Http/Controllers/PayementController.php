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
        $payements = Payement::with(['user', 'commande'])->get();

        // Transformer les données pour inclure le nom de l'utilisateur et la référence de la commande
        $payements = $payements->map(function($payement) {
            return new PayementResource($payement);
        });

        return $this->successResponse($payements);
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
