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

        return $this->sucessResponseWithPaginate(
            PayementResource::class, 
            Payement::with(['user', 'commande'])->orderBy('created_at', 'desc')->paginate(20), 
            'payements'
            );

    }

    public function store(StorePayementRequest $request)
    {
        $payement = Payement::create($request->all());
        event(new PayementReceived($payement->commande_id));

        return $this->successResponse(new PayementResource($payement), 'Payment received and status updated.', 201);
    }

    public function show($id)
    {
        $payement =Payement::find($id);
        if ($payement==null)
        {
            return $this-> errorResponse("Payement not found");
        }
        return $this->successResponse(new PayementResource($payement));
    }

    public function update(UpdatePayementRequest $request, $id)
    {
        $payement =Payement::find($id);
        if ($payement==null)
        {
            return $this-> errorResponse("Payement not found");
        }
        $payement->update($request->all());
        return $this->successResponse(new PayementResource($payement), 'Payment updated successfully', 200);
    }

    public function destroy($id)
    {
        $payement =Payement::find($id);
        if ($payement==null)
        {
            return $this-> errorResponse("Payement not found");
        }
        $payement->delete();
        return $this->successResponse(null, 'Payment deleted successfully', 204);
    }
}
